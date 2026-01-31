<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('user')->middleware(['auth','role:user'])->name('user.')->controller(UserController::class)->group(function () {
    Route::get('index', 'index')->name('index');
    Route::get('search','search')->name('search');
    Route::get('filter','filter')->name('filter');
    Route::get('create','create')->name('create');
    Route::post('store','store')->name('store');
    Route::get('myreview','myreview')->name('myreview');
    Route::get('favorite_page','favorite_page')->name('favorite_page');
    Route::get('{id}/myfavor','myfavor')->name('myfavor');
    Route::get('{id}/show','show')->name('show');
    Route::get('{id}/edit','edit')->name('edit');
    Route::post('{id}/report','report')->name('report');
    Route::delete('{id}/delete/report','delete_report')->name('delete_report');
    Route::put('{id}/update','update')->name('update');
    Route::delete('{id}/delete','destroy')->name('destroy');
});