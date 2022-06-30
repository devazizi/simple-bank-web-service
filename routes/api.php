<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('login');
});

Route::middleware([])->group(function () {

    Route::namespace('Transactions')->group(function () {
        Route::get('card-transactions/have-must-transaction', 'IndexTransaction@getThreeUserHasMostTransaction');
        Route::post('/card-transactions', 'CreateTransaction@createTransactionFromCardToCard');
    });
});
