<?php

namespace App\Http\Controllers\ServiceContainer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Packages\MyServiceContainerTest\MyTestServiceContainer;

class ServiceContainerController extends Controller
{
    //
    public function container(MyTestServiceContainer $myTestServiceContainer)
    {
        dump($myTestServiceContainer);
        $myTestServiceContainer->getMyTest();
    }
}
