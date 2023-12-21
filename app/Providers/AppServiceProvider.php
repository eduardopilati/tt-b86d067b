<?php
// phpcs:ignoreFile

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use App\Classes\PaginationUrlWindow;
use Illuminate\Pagination\UrlWindow;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias(UrlWindow::class, PaginationUrlWindow::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
