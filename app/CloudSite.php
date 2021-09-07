<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudSite extends Model
{
    protected $fillable = ['name', 'description'];

    public function domains()
    {
        return $this->hasMany('App\cloudDomain');
    }
    public function account()
    {
        return $this->hasMany('App\CloudAccount');
    }

    public function domainInAccount()
    {
        return $this->hasMany('App\cloudDomain');
    }
    
}
