<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // // dd('AuthServiceProvider');

        // Gate::define('access-filament', function (User $user) {
        //     // برای تست: اگر می‌خوای ببینی کاربر اومده یا نه، این خط رو فعال کن
        //     // dd($user);

        //     return $user->is_admin==1; // فقط ادمین‌ها اجازه دارند
        // });
    }
}
