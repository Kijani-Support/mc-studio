<?php

use Illuminate\Http\Request;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function(){
     Route::post('register', 'register');
     Route::post('login','login');
});

Route::group(['middleware'=>['auth:sanctum']],function(){
        //User Routes//
        Route::get('users',[CustomerController::class, 'index']);
        Route::post('createUser',[CustomerController::class, 'store']);

        //End of User Routes//

        //Product Routes//
        Route::get('products',[ProductController::class, 'index']);

       //End of Product Routes//

       //Order Routes//
        Route::get('orders',[OrderController::class, 'index']);

       //End of Order Routes//

       //Quotation Routes//
        Route::get('quotations',[QuotationController::class, 'index']);

       //End of Quotation Routes//

       //Transaction Routes//
        Route::get('transactions', [TransactionController::class, 'index']);
        Route::get('transactions/{id}', [TransactionController::class, 'show']);
        Route::get('users/{userId}/transactions', [TransactionController::class, 'byUser']);

       //End of Transaction Routes//

    }
);
//Route::apiResource('posts', ProductController::class)->middleware('auth:sanctum');