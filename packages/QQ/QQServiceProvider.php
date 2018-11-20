<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2018/11/20
 * Time: 15:24
 */

namespace Packages\QQ;


use Illuminate\Support\ServiceProvider;
use Packages\QQ\src\QQ;

class QQServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__ . "/config/qq.php" => config_path('qq.php')
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton("QQ\QQ", function (){
            return new QQ();
        });
    }
}
