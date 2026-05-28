<?php

namespace App\Providers;

use App\Http\Services\AdminContactService;
use App\Http\Services\ContactService;
use App\Http\Services\Contracts\AdminContactServiceInterface;
use App\Http\Services\Contracts\ContactServiceInterface;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(AdminContactServiceInterface::class, AdminContactService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(\App\Services\Contracts\UserServiceInterface::class, \App\Services\UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for Carbon 3.x "Undefined array key" error
        $locale = config('app.locale', 'en');
        \Carbon\Carbon::getTranslator()->setMessages($locale, []);

        $fallback = config('app.fallback_locale', 'en');
        if ($fallback !== $locale) {
            \Carbon\Carbon::getTranslator()->setMessages($fallback, []);
        }
    }
}
