<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\CloudSite;
class cloudDomain extends Model
{
    protected $fillable = [
        'cloud_account_id', 'zone_id', 'name', 'status', 'security_level', 'ssl_setting',
        'ipv6', 'name_server1', 'name_server2', 'plan'
    ];

    public function getDomains()
    {
        $dt = Carbon::now();
        $add15 = $dt->copy()->addDays(15);
        $sub20 = $dt->copy()->subDay(5);
        $domains = cloudDomain::where([
            ['expire_date', '<', $add15],
            ['expire_date', '>', $sub20]
        ])->get();
        foreach ($domains as $key => $value) {
            $site = CloudSite::find($value['cloud_site_id']);
            $domains[$key]['site'] = $site['description'];
        }
        return $domains;
        
    }
    public function sites()
    {
        return $this->belongsTo('App\CloudSite');
    }

    public function account()
    {
        return $this->belongsTo('App\CloudAccount', 'cloud_account_id');
    }

    public function domain_dns()
    {
        return $this->hasMany('App\CloudDn');
    }
    
    public function hasOneSite()
    {
        return $this->belongsTo('App\CloudSite');
    }
}
