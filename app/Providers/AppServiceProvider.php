<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force the root URL so all route() / url() helpers use the correct
        // subdirectory prefix even on shared hosting with a flat deployment.
        URL::forceRootUrl(config('app.url'));

        // Force HTTPS in production.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
