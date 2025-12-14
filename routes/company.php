<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::prefix('company')->middleware(['auth','role:company'])->name('company.')->controller(CompanyController::class)->group(function () {
    Route::get('index', 'index')->name('index');
});