<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2018/11/21
 * Time: 13:42
 */

namespace Packages\MyServiceContainerTest;

use Illuminate\Support\ServiceProvider;
use Packages\MyServiceContainerTest\MyInterface\BaseMyTestInterface;
use Packages\MyServiceContainerTest\Test\MyTestDoc;
use Packages\MyServiceContainerTest\Test\MyTestUnit;

class MyServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {

        $this->app->bind(MyTestServiceContainer::class, function (){
            // 递归了，用app make，不断地调用此方法
            // return $this->app->make(MyTestServiceContainer::class);
            // 返回当前对象
            return new MyTestServiceContainer($this->app->make(BaseMyTestInterface::class));
        });

        // 依赖接口的参数，实例的注入
        // MyTestUnit实现了BaseMyTestInterface接口，
        // 如果有有其他类需要BaseMyTestInterface的注入，
        // 此函数实现了用MyTestUnit去注入到编写了BaseMyTestInterface类的参数里面
        $this->app->bind(BaseMyTestInterface::class,MyTestUnit::class);
    }
}
