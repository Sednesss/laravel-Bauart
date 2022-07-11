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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'App\Http\Controllers\API\RegisterController@register')->name('register');
Route::post('login', 'App\Http\Controllers\API\LoginController@login')->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('image/loading', 'App\Http\Controllers\API\LoadingImageController@loading')->name('image.loading');
    Route::post('image/downloading', 'App\Http\Controllers\API\DownloadingImageController@downloading')
        ->name('image.downloading');
    Route::post('images_stack/downloading', 'App\Http\Controllers\API\DownloadingImagesStackController@downloading')
        ->name('images_stack.downloading');
});
