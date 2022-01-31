<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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
    auth()->loginUsingId(3);
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'homeController@index')->name('home');

Route::get('/auth/google/redirect', 'GoogleAuthController@redirect')->name('auth.google');
Route::get('/auth/google/callback', 'GoogleAuthController@callback');

Route::get('/test', function () {
    return "test page";
})->middleware('password.confirm');

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::get('/2fa/settings', 'TwoFactorController@index')->name('2fa.settings');
    Route::post('/2fa/settings', 'TwoFactorController@settings')->name('2fa.settings');
    Route::get('/2fa/verify/mobile', 'TwoFactorController@getVerifyMobile')->name('2fa.verify.mobile');
    Route::post('/2fa/verify/mobile', 'TwoFactorController@postVerifyMobile')->name('2fa.verify.mobile');
});

Route::get('/auth/2fa', 'TwoFactorController@getAuthCode')->name('auth.2fa');
Route::post('/auth/2fa', 'TwoFactorController@postAuthCode')->name('auth.2fa');


Route::get('/mail',function (){
    return view('auth.email.reset-password');
});

Route::get('products','ProductController@index')->name('products.index');
Route::get('products/{product}','ProductController@single')->name('products.single');
Route::post('comments/send','CommentController@send')->name('comment.send')->middleware(['auth']);

Route::get('/add/to/cart/{product}','CartController@add')->name('add-to-cart');
Route::get('/cart','CartController@index')->name('cart');
Route::patch('/cart/quantity/change','CartController@update');
Route::delete('/cart/destroy','CartController@destroy')->name('cart.destroy');
Route::get('/pay/redirect','PaymentController@redirect')->name('payment.redirect')->middleware('auth');
Route::get('/pay/verify','PaymentController@verify')->name('payment.callback')->middleware('auth');
Route::post('/discount/check','DiscountController@check')->name('discount.check');
Route::get('/discount/delete','DiscountController@deleteDiscount')->name('discount.delete');
