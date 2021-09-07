<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CloudSite;
use App\CloudAccount;
use App\cloudDomain;

class CloudSiteController extends Controller
{
    public function getSite()
    {
        return CloudSite::all();
    }

    public function domainList(Request $request)
    {
        if ($request->id) {
            // $account = cloudDomain::with('account')->find(4);
            // dd($account);
            $site = CloudSite::with('domains.account')->find( $request->id);
            // dump($site->domains[0]->account->site_name);
            // dump($site->account->count());
            if($site->account->count() > 0)
            foreach ($site->domains as $key => $value) {
                $site->domains[$key]['account_name'] = $value['account']['account'];
                $site->domains[$key]['site_name'] = $site['name'];
            }           
            return $site->domains;
        } elseif ($request->account_id) {
            $domains =  CloudAccount::find($request->account_id)->account_domain()->get();
        } else {
            $domains =  cloudDomain::all();
        }
        foreach ($domains as $key => $value) {
            // $site = CloudSite::find($value['cloud_site_id']);
            // $domains[$key]['site'] = $site['description'];
            // $account = CloudAccount::find($value['cloud_account_id']);
            // $domains[$key]['account'] = $account['account'];
        }
        return $domains;
    }

    public function addSite(Request $request)
    {
        dump($request);
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        CloudSite::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }
}
