<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->middleware(['auth','role:admin'])->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('index', 'index')->name('index');
});