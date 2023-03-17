<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LinkListController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VideoController;
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

Route::controller(LinkListController::class)->prefix('link-list')->group(function () {
    Route::get('list', 'list')->name('link-list.list');
    Route::post('create', 'create')->name('link-list.create');
    Route::get('get/{id}', 'get')->name('link-list.get');
    Route::put('update/{id}', 'update')->name('link-list.update');
    Route::delete('delete/{id}', 'delete')->name('link-list.delete');
});

Route::controller(LinkController::class)->prefix('link')->group(function () {
    Route::get('list', 'list')->name('link.list');
    Route::post('create', 'create')->name('link.create');
    Route::get('get/{id}', 'get')->name('link.get');
    Route::put('update/{id}', 'update')->name('link.update');
    Route::delete('delete/{id}', 'delete')->name('link.delete');
});

Route::controller(PassengerController::class)->prefix('passenger')->group(function () {
    Route::get('list', 'list')->name('passenger.list');
    Route::post('create', 'create')->name('passenger.create');
    Route::get('get/{id}', 'get')->name('passenger.get');
    Route::put('update/{id}', 'update')->name('passenger.update');
    Route::delete('delete/{id}', 'delete')->name('passenger.delete');
});

Route::controller(VehicleController::class)->prefix('vehicle')->group(function () {
    Route::get('list', 'list')->name('vehicle.list');
    Route::post('create', 'create')->name('vehicle.create');
    Route::get('get/{id}', 'get')->name('vehicle.get');
    Route::put('update/{id}', 'update')->name('vehicle.update');
    Route::delete('delete/{id}', 'delete')->name('vehicle.delete');
});

Route::controller(DriverController::class)->prefix('driver')->group(function () {
    Route::get('list', 'list')->name('driver.list');
    Route::post('create', 'create')->name('driver.create');
    Route::get('get/{id}', 'get')->name('driver.get');
    Route::put('update/{id}', 'update')->name('driver.update');
    Route::delete('delete/{id}', 'delete')->name('driver.delete');
});

Route::controller(SchoolController::class)->prefix('school')->group(function () {
    Route::get('list', 'list')->name('school.list');
    Route::post('create', 'create')->name('school.create');
    Route::get('get/{id}', 'get')->name('school.get');
    Route::put('update/{id}', 'update')->name('school.update');
    Route::delete('delete/{id}', 'delete')->name('school.delete');
});

Route::controller(StandardController::class)->prefix('standard')->group(function () {
    Route::get('list', 'list')->name('standard.list');
    Route::post('create', 'create')->name('standard.create');
    Route::get('get/{id}', 'get')->name('standard.get');
    Route::put('update/{id}', 'update')->name('standard.update');
    Route::delete('delete/{id}', 'delete')->name('standard.delete');
});

Route::controller(StudentController::class)->prefix('student')->group(function () {
    Route::get('list', 'list')->name('student.list');
    Route::post('create', 'create')->name('student.create');
    Route::get('get/{id}', 'get')->name('student.get');
    Route::put('update/{id}', 'update')->name('student.update');
    Route::delete('delete/{id}', 'delete')->name('student.delete');
});

Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('list', 'list')->name('role.list');
    Route::post('create', 'create')->name('role.create');
    Route::get('get/{id}', 'get')->name('role.get');
    Route::put('update/{id}', 'update')->name('role.update');
    Route::delete('delete/{id}', 'delete')->name('role.delete');
});

Route::controller(RoleUserController::class)->prefix('role-user')->group(function () {
    Route::get('list', 'list')->name('role-user.list');
    Route::post('create', 'create')->name('role-user.create');
    Route::get('get/{id}', 'get')->name('role-user.get');
    Route::put('update/{id}', 'update')->name('role-user.update');
    Route::delete('delete/{id}', 'delete')->name('role-user.delete');
});

Route::controller(UserController::class)->prefix('profile')->group(function () {
    Route::get('list', 'list')->name('profile.list');
    Route::post('create', 'create')->name('profile.create');
    Route::get('get/{id}', 'get')->name('profile.get');
    Route::put('update/{id}', 'update')->name('profile.update');
    Route::delete('delete/{id}', 'delete')->name('profile.delete');
});

Route::controller(ProductController::class)->prefix('product')->group(function () {
    Route::get('list', 'list')->name('product.list');
    Route::post('create', 'create')->name('product.create');
    Route::get('get/{id}', 'get')->name('product.get');
    Route::put('update/{id}', 'update')->name('product.update');
    Route::delete('delete/{id}', 'delete')->name('product.delete');
});

Route::controller(VideoController::class)->prefix('video')->group(function () {
    Route::get('list', 'list')->name('video.list');
    Route::post('create', 'create')->name('video.create');
    Route::get('get/{id}', 'get')->name('video.get');
    Route::put('update/{id}', 'update')->name('video.update');
    Route::delete('delete/{id}', 'delete')->name('video.delete');
});

Route::controller(SongController::class)->prefix('song')->group(function () {
    Route::get('list', 'list')->name('song.list');
    Route::post('create', 'create')->name('song.create');
    Route::get('get/{id}', 'get')->name('song.get');
    Route::put('update/{id}', 'update')->name('song.update');
    Route::delete('delete/{id}', 'delete')->name('song.delete');
});

Route::controller(TagController::class)->prefix('tag')->group(function () {
    Route::get('list', 'list')->name('tag.list');
    Route::post('create', 'create')->name('tag.create');
    Route::get('get/{id}', 'get')->name('tag.get');
    Route::put('update/{id}', 'update')->name('tag.update');
    Route::delete('delete/{id}', 'delete')->name('tag.delete');
});
