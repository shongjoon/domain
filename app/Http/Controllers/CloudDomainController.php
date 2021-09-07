<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cloudDomain;
use Carbon\Carbon;
use App\CloudSite;
use App\CloudAccount;
use Cloudflare\Api;
use Cloudflare\Zone;

class CloudDomainController extends Controller
{
    protected $domain;
    public function __construct()
    {
        $this->domain = new cloudDomain();
    }
    public function getDomain(request $request)
    {
        $test = $this->domain->getDomains();
        return response()->json($test);

        // $dt = Carbon::now();
        // $add15 = $dt->copy()->addDays(15);
        // $sub20 = $dt->copy()->subDay(5);

        // $domains = cloudDomain::where([
        //     ['expire_date', '<', $add15],
        //     ['expire_date', '>', $sub20]
        // ])->get();
        // foreach ($domains as $key => $value) {
        //     $site = CloudSite::find($value['cloud_site_id']);
        //     $domains[$key]['site'] = $site['description'];
        // }
        // return $domains;

    }

    public function cloudAddDomain(Request $request)
    {
        $stmt = CloudAccount::where('account', $request->account)->first();
        $client = new Api($stmt['account'], $stmt['api_key']);
        $zone = new Zone($client);
        $creat_zone = $zone->create($request->name);
        // dump($creat_zone->errors[0]->message);
        if ($creat_zone->success) {
            return json_encode(array('success' => 'cloudflare zone 데이터를 생성하는데  성공했습니다. '));
        } elseif($creat_zone->errors[0]->code == 1002) {
            return json_encode(array('error' => $creat_zone->errors[0]->message));
        } else {
            return json_encode(array('error' => 'cloudflare zone 데이터를 생성하는데  실패했습니다. '));
        }
    }
}
