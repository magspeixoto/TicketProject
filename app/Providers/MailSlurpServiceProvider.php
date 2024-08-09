<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MailSlurp\Configuration;
use MailSlurp\Apis\InboxControllerApi;

class MailSlurpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(InboxControllerApi::class, function ($app) {
            $config = Configuration::getDefaultConfiguration()->setApiKey('x-api-key', env('MAILSLURP_API_KEY'));
            return new InboxControllerApi(null, $config);
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
