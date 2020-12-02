<?php

namespace mabw\Validate;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test features from kmom05.
 */
class ApiWeatherTest extends TestCase
{
    public function setUp()
    {
        global $di;

        $di = new DIMagic();
        $di->loadServices("config/di");

        $this->controller = new ApiWeatherController();
        $this->controller->setDi($di);
    }

    public function testIndex()
    {
        $_POST["ip"] = "172.217.21.142";
        $_POST["test"] = true;
        $res = $this->controller->indexAction();

        if (is_array($res)) {
            $this->assertIsArray($res);
        } else {
            $this->assertIsString($res);
        }
    }

    public function testIndexNull()
    {
        $_POST["ip"] = null;
        $_POST["test"] = true;
        $res = $this->controller->indexAction();
        $this->assertIsString($res);
    }
}
