<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\LinkListController;
use App\Http\Controllers\VoteController;
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

Route::controller(VoteController::class)->prefix('vote')->group(function () {
    Route::get('list', 'list')->name('vote.list');
    Route::post('create', 'create')->name('vote.create');
    Route::get('get/{id}', 'get')->name('vote.get');
    Route::put('update/{id}', 'update')->name('vote.update');
    Route::delete('delete/{id}', 'delete')->name('vote.delete');
});

Route::controller(LinkListController::class)->prefix('link-list')->group(function(){
    Route::get('list', 'list')->name('link-list.list');
    Route::post('create', 'create')->name('link-list.create');
    Route::get('get/{id}', 'get')->name('link-list.get');
    Route::put('update/{id}', 'update')->name('link-list.update');
    Route::delete('delete/{id}', 'delete')->name('link-list.delete');
});

Route::controller(LinkController::class)->prefix('link')->group(function(){
    Route::get('list', 'list')->name('link.list');
    Route::post('create', 'create')->name('link.create');
    Route::get('get/{id}', 'get')->name('link.get');
    Route::put('update/{id}', 'update')->name('link.update');
    Route::delete('delete/{id}', 'delete')->name('link.delete');
});
