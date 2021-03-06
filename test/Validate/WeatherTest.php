<?php

namespace mabw\Validate;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test features from kmom05.
 */
class WeatherTest extends TestCase
{
    public function setUp()
    {
        global $di;

        $di = new DIMagic();
        $di->loadServices("config/di");

        $this->controller = new WeatherController();
        $this->controller->setDi($di);
    }

    public function testIndex()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testShowResult()
    {
        $_POST["ip"] = "8.8.8.8";
        $_POST["test"] = true;
        $res = $this->controller->showResultAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testShowResultIp6() {
        $_POST["ip"] = "2001:4860:4860::8888";
        $_POST["test"] = true;
        $res = $this->controller->showResultAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testShowResultFail()
    {
        $_POST["ip"] = "8.8.8.8dsadasdsa";
        $_POST["test"] = true;
        $res = $this->controller->showResultAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
