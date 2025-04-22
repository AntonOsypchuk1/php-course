<?php

namespace App\Providers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\CategoryService;
use App\Services\FineService;
use App\Services\LoanService;
use App\Services\ReservationService;
use App\Services\RoleService;
use App\Services\SystemSettingService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RoleService::class);
        $this->app->singleton(UserService::class);
        $this->app->singleton(AuthorService::class);
        $this->app->singleton(BookService::class);
        $this->app->singleton(CategoryService::class);
        $this->app->singleton(FineService::class);
        $this->app->singleton(LoanService::class);
        $this->app->singleton(ReservationService::class);
        $this->app->singleton(SystemSettingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
