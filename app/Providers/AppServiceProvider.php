<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive(); // <--- 2. เพิ่มบรรทัดนี้ (ถ้าใช้ Bootstrap 5)
        // หรือ Paginator::useBootstrapFour(); // ถ้าใช้ Bootstrap 4
    }
}
