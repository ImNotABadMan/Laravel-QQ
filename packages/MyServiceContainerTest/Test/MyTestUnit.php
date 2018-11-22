<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2018/11/21
 * Time: 14:06
 */

namespace Packages\MyServiceContainerTest\Test;


use Packages\MyServiceContainerTest\MyInterface\BaseMyTestInterface;

class MyTestUnit implements BaseMyTestInterface
{
    public function getBaseTest()
    {
        // TODO: Implement getBaseTest() method.
        dump(self::class);
    }
}
