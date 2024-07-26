<?php

namespace App\Providers;

use App\Services\MailSlurpService;
use Illuminate\Support\ServiceProvider;
use MailSlurp\Api\InboxControllerApi;
use MailSlurp\Configuration;

class MailSlurpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
