<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cloud_coin;

class CloudCoinController extends Controller
{
    public function getCoins() 
    {
        $account_coin = Cloud_coin::groupBy('account')
            ->selectRaw('*,sum(account_coin) as coin' )
            ->get();
        $coin_list = Cloud_coin::orderBy('id', 'desc')->get();
        return $data = [
            'account_coin' => $account_coin,
            'coin_list' => $coin_list
        ];
    }
}
