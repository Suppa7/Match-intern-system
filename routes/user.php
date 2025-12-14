<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('user')->middleware(['auth','role:user'])->name('user.')->controller(UserController::class)->group(function () {
    Route::get('index', 'index')->name('index');
});