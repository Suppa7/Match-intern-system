<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'redirectTo'])->name('login');

Route::get('/home', function () {
    $user = Auth::user()->role;
    
    return match ($user) {
        'admin'   => redirect()->route('admin.index'),
        'company' => redirect()->route('company.index'),
        'student' => redirect()->route('user.index'),
    };
})->name('home');

Auth::routes();

include __DIR__ . '/admin.php';
include __DIR__ . '/user.php';
include __DIR__ . '/company.php';




