<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudAccount extends Model
{
    protected $fillable = ['account', 'api_key', 'site_name'];

    public function account_domain()
    {
        return $this->hasMany('App\cloudDomain');
    }
}
