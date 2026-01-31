<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->middleware(['auth','role:admin'])->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('index', 'index')->name('index');
    Route::get('report','report')->name('report');
    Route::get('{id}/show','show')->name('show');
    Route::delete('{id}/delete/review','delete_review')->name('delete_review');

    Route::get('manage/user','user')->name('user');
    Route::get('manage/user/edit/{id}','user_edit')->name('user_edit');
    Route::put('manage/user/update/{id}','user_update')->name('user_update');
    Route::delete('manage/user/delete/{id}','user_destroy')->name('user_destroy');
    
});