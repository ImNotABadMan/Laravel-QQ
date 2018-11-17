<?php

namespace App\Providers;

use App\Lib\PHPImap\Gmail\GmailConnection;
use App\Lib\PHPImap\QQ\QQConnection;
use Illuminate\Support\ServiceProvider;

class PHPImapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('Imap\\Connection\\Gmail', function ($app){
            return new GmailConnection();
        });

        $this->app->singleton('Imap\\Connection\\QQ', function ($app){
            return new QQConnection();
        });
    }
}
