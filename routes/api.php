<?php

use App\Http\Controllers\AuthC;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PeminjamanC;
use App\Http\Controllers\BukuC;
use App\Http\Controllers\usersC;

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

Route::get('/about', function(){
    return 'Salsabila Dan Novaliza';
});

Route::apiResource('/buku', BukuC::class);
Route::apiResource('/peminjaman', PeminjamanC::class) -> middleware(['auth:sanctum']);
Route::apiResource('/users', usersC::class);

route::post('/login',[AuthC::class,'login']);

route::get('/kasir',function(){
    return Hash::make('kasir');
});