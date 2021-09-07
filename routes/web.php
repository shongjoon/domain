<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::any('{shug}', function() {
    return view('home');
});

Route::post('app/create_memo', 'DashBoardController@addMemo' );
Route::get('app/get_memos', 'DashBoardController@getMemo' );
Route::post('app/edit_memo', 'DashBoardController@editMemo' );
Route::post('app/delete_memo', 'DashBoardController@deleteMemo' );
Route::get('app/get_coins', 'CloudCoinController@getCoins' );


Route::get('app/get_domain', 'CloudDomainController@getDomain' );

Route::get('app/get_site', 'CloudSiteController@getSite' );
Route::post('app/domain_list', 'CloudSiteController@domainList' );

Route::get('app/get_accounts', 'CloudAccountController@getAccounts' );
Route::post('app/update_account', 'CloudAccountController@updateAccount' );

Route::post('app/add_account', 'CloudAccountController@addAccount' );
Route::post('app/add_site', 'CloudSiteController@addSite' );
Route::post('app/cloud_add_domain', 'CloudDomainController@cloudAddDomain' );

