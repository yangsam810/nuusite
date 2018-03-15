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
    return view('welcome');
});

// PageController
Route::get('/site/{unit}','PageController@selet');
Route::get('/site/{unit}/rule','PageController@siteRulePage');
Route::get('/site/{unit}/{schoolSite}/search','PageController@siteSearchPage');
Route::get('/site/{unit}/login','PageController@userLoginPage');
Route::get('/site/{unit}/apply','PageController@siteApplyPage')				->middleware('auth.user');
Route::get('/site/{unit}/state','PageController@siteStatePage')				->middleware('auth.user');
Route::get('/site/{unit}/history','PageController@siteHistoryPage')			->middleware('auth.user');
Route::get('/site/{unit}/view/{id}','PageController@siteViewPage')			->middleware('auth.user')->name('viewApply');
Route::get('/site/{unit}/success/{id}','PageController@siteSuccessPage')	->middleware('auth.user');
Route::get('/site/{unit}/check','PageController@siteCheckPage')				->middleware('auth.user')->middleware('auth.admin');
Route::get('/site/{unit}/allhistory','PageController@siteAdminHistoryPage')	->middleware('auth.user')->middleware('auth.admin');

Route::get('/site/404NotFound','PageController@NotFoundPage');
// ApplyController
Route::post('/site/{unit}/apply/submit','ApplyController@store');
Route::get ('/site/{unit}/apply/delete/{id}','ApplyController@cancel')		->middleware('auth.user')->middleware('auth.admin')->name('cancelApply');
Route::get ('/site/{unit}/apply/check/delete/{id}','ApplyController@del')	->middleware('auth.user')->middleware('auth.admin')->name('deleteApply');
Route::get ('/site/{unit}/apply/check/pass/{id}','ApplyController@pass')	->middleware('auth.user')->middleware('auth.admin')->name('passApply');
Route::get ('/site/{unit}/apply/check/nopass/{id}','ApplyController@nopass')->middleware('auth.user')->middleware('auth.admin')->name('nopassApply');

// UserController
Route::post('/site/{unit}/user/submitLogin','UserController@userLogin');
Route::get('/site/{unit}/user/logout','UserController@userLogout');
//Route::get('/site/{unit}/user/logout','ApplyController@sendMail');

// UnitController

Route::post('/submitApply','AdminController@store');