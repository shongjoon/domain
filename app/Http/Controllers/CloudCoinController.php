<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cloud_coin;

class CloudCoinController extends Controller
{
    public function getCoins() 
    {

        $test = Cloud_coin::groupBy('account')
        ->selectRaw('*,sum(account_coin) as coin')
        ->get();
        foreach ($test as $key => $value) {
            
        }
        // $input_count = $test->countBy('account'); // 입력횟수 
        // return response()->json($input_count);

        return response()->json($test);
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
