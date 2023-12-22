<?php
// phpcs:ignoreFile

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use App\Classes\PaginationUrlWindow;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias(UrlWindow::class, PaginationUrlWindow::class);

        if (Str::contains(Config::get('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
