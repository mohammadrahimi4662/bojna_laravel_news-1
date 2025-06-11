<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Filament\Panel;
use Filament\Facades\Filament;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
            Filament::serving(function () {
            if (auth()->check() && auth()->user()->is_admin != 1) {
                // ری‌دایرکت همراه با پیام خطا
                redirect()
                    ->route('customer.home')
                    ->with('error', 'دسترسی غیرمجاز')
                    ->send(); // خیلی مهم: باعث می‌شه ریدایرکت فوراً اجرا بشه

                exit; // برای اطمینان از توقف کامل اجرا
            }
        });
    }
}
