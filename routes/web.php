<?php

use App\Http\Controllers\Stripe\StripeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/checkout', function () {

    return view('checkout');

    // return view('Pusher');

});
Route::get('/success', function () {

    return view('success');

});
Route::get('/cancel', function () {

    return view('cancel');

});
Route::get('/print', function () {

    return view('print.invoice');

});
Route::get('/firebase', function () {

    return view('firebase');

});
Route::controller(StripeController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
Route::post('createPaymentIntent',[StripeController::class,'createPaymentIntentweb'])->name('createPaymentIntent');
