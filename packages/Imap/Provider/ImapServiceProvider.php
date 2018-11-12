<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-11
 * Time: 22:09
 */

namespace Packages\Imap\Provider;

use Illuminate\Support\ServiceProvider;

class ImapServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/imap.php' => config_path('imap.php')
        ]);
    }
}
