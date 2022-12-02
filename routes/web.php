<?php

use App\Http\Controllers\ProductController;
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
    return redirect()->route('products.index');
});
Route::resource('products', ProductController::class);
Route::post('/store_data', 'App\Http\Controllers\ProductController@storeData')->name('store_data');
Route::post('/update_data', 'App\Http\Controllers\ProductController@updateData')->name('update_data');
