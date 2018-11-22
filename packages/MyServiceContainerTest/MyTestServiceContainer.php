<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2018/11/21
 * Time: 13:46
 */

namespace Packages\MyServiceContainerTest;


use Packages\MyServiceContainerTest\MyInterface\BaseMyTestInterface;

class MyTestServiceContainer
{
    private $_baseMyTest;

    public function __construct(BaseMyTestInterface $baseMyTest)
    {
        $this->_baseMyTest = $baseMyTest;
    }

    public function getMyTest()
    {
        $this->_baseMyTest->getBaseTest();
    }
}
