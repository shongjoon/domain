<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CloudAccount;
use App\CloudSite;
use App\cloudDomain;
use Cloudflare\API;
use Cloudflare\Zone;
use Cloudflare\Zone\Settings;

class CloudAccountController extends Controller
{
    public function getAccounts()
    {
        $account_list = CloudAccount::with('account_domain')->orderBy('updated_at', 'desc')->get();
        foreach ($account_list as $key => $value) {
            $account_list[$key]['count'] = count($value['account_domain']);
        }
        return $account_list;
    }

    public function addAccount(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'api_key' => 'required',
            'site_name' => 'required'
        ]);
        CloudAccount::create([
            'account' => $request->account,
            'api_key' => $request->api_key,
            'site_name' => $request->site_name
        ]);
    }
    public function updateAccount(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required'
        ]);
        $stmt = CloudAccount::find($request->account_id);
        if (!$stmt) {
            return json_encode(array('error' => 'account 정보가  없습니다.'));
        }
        $client = new Api($stmt['account'], $stmt['api_key']);
        $Zones = new Zone($client);
        $Settings = new Settings($client);
        $zones = $Zones->zones();

        if (!$zones->success) {
            $err = $zones->errors[0]['message'];
            return  json_encode(array('error' => $err));
        }

        // dump($zones->result);
        $zones = json_decode(json_encode($zones), true);
        $domain_ids = array();
        foreach ($zones['result'] as $key => $value) {
            //$value->id = b77459d36722bbff6b2614e96420ca9b
            $zone_setting_obj = $Settings->settings($value['id']);
            // dump('$zone_setting_obj',$zone_setting_obj->result);
            array_push($domain_ids, $value['id']);
            $zone_setting = array();
            foreach ($zone_setting_obj->result as $setting) {
                if ($setting->editable) {
                    $zone_setting[$setting->id] = $setting->value;
                }
            }

            try {
                cloudDomain::updateOrCreate(
                    ['zone_id' => $value['id']],
                    [
                        'status' => $value['status'],
                        'cloud_account_id' => $request->account_id,
                        'zone_id' => $value['id'],
                        'name' => $value['name'],
                        'security_level' => $zone_setting['security_level'],
                        'ssl_setting' => $zone_setting['ssl'],
                        'ipv6' => $zone_setting['ipv6'],
                        'name_server1' => $value['name_servers'][0],
                        'name_server2' => $value['name_servers'][1],
                        'plan' => $value['plan']['name'],
                    ]
                );
                return json_encode(array('success' => '도메인 정보가 업데이트 되었습니다 .'));
            } catch (\Throwable $th) {
                return json_encode(array('error' => '도메인 정보가 업데이트중 오류가 생겼습니다 .'));
                //throw $th;
            }


            // if (isset($stmt_check[0]->id)) {
            // } else {
            //     return json_encode(array('success' => '도메인 정보가 업데이트 되었습니다 .'));
            // }
        }
        // $stmt_check = cloudDomain::

    }
}
