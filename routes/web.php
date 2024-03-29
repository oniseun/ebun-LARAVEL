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

Route::redirect('/', 'home', 301);
Route::redirect('index', 'home', 301);
Route::get('home','IndexController@home');
Route::get('about', 'IndexController@about');
Route::get('contact', 'IndexController@contactForm');
Route::post('finalize/contact', 'IndexController@contact');
Route::post('finalize/register', 'AuthController@register');
Route::post('finalize/login', 'AuthController@login');
Route::get('reset', 'AuthController@forgotPasswordForm');
Route::post('finalize/reset', 'AuthController@reset');

Route::get('reset/password/{reset_code}', 'AuthController@resetPasswordForm')->where('reset_code', '[A-Za-z0-9_\-]+');
Route::post('finalize/reset/password', 'AuthController@resetPassword');
Route::get('finalize/verify/email/{verify_code}', 'AuthController@verifyEmail')->where('verify_code', '[A-Za-z0-9_\-]+');

Route::get('anniversary/{aID}', 'AnniversaryController@info')->where('aID', '[A-Za-z0-9_\-]+');
Route::post('finalize/deactivate/item', 'ItemController@deactivate');

Route::get('cron/job/dispatch/email', 'CronController@dispatchEmail');
Route::get('cron/job/dispatch/sms', 'CronController@dispatchSMS');


Route::group(['prefix' => 'admin','middleware' =>'web.auth'], function () {


Route::get('dashboard', 'AnniversaryController@listView');
Route::get('update/anniversary/{aID}', 'AnniversaryController@updateForm')->where('aID', '[A-Za-z0-9_\-]+');
Route::get('remove/anniversary/{aID}', 'AnniversaryController@confirmDelete')->where('aID', '[A-Za-z0-9_\-]+');
Route::post('finalize/update/anniversary', 'AnniversaryController@update');
Route::post('finalize/remove/anniversary', 'AnniversaryController@remove');
Route::post('finalize/add/anniversary', 'AnniversaryController@add');

Route::post('finalize/add/item', 'ItemController@add');

Route::get('my/profile', 'ProfileController@profileInfo');
Route::get('my/password', 'ProfileController@profilePassword');
Route::get('my/photo', 'ProfileController@profilePhoto');

Route::post('finalize/update/profile/info', 'ProfileController@updateInfo');
Route::post('finalize/update/profile/password', 'ProfileController@updatePassword');
Route::post('finalize/update/profile/photo', 'ProfileController@updatePhoto');

Route::get('logout', 'AuthController@logoutForm');
Route::post('finalize/logout', 'AuthController@logout');
Route::get('finalize/resend/verification', 'AuthController@resendVerification');


});