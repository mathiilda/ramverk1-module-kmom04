<?php

namespace mabw\Validate;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test features from kmom05.
 */
class WeatherRestTest extends TestCase
{
    public function setUp()
    {
        global $di;

        $di = new DIMagic();
        $di->loadServices("config/di");

        $this->controller = new WeatherRESTController();
        $this->controller->setDi($di);
    }

    public function testIndex()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testShowResult()
    {
        $_POST["ip"] = "127.0.0.1";
        $_POST["test"] = true;
        $res = $this->controller->showResultAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testShowResultFail()
    {
        $_POST["ip"] = "127.0.0.1hejhej";
        $_POST["test"] = true;
        $res = $this->controller->showResultAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
