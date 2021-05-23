<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

Route::redirect('/', 'login');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
        Route::get('users-list', [UsersController::class, 'usersList']);
        Route::get('usersListAjaxHandler', [UsersController::class, 'usersListAjaxHandler']);
        Route::post('fetchUserDetails', [UsersController::class, 'fetchUserDetails']);
        Route::post('updateUser', [UsersController::class, 'updateUser']);
        Route::post('deleteUser', [UsersController::class, 'deleteUser']);
        Route::get('logout', [AuthController::class, 'logout']);
});
