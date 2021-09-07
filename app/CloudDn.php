<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudDn extends Model
{
    public function dn_domain()
    {
        return $this->belongsTo('App\cloudDomain');
    }
}
