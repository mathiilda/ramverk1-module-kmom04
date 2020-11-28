<?php

namespace Anax\Validate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class WeatherRESTController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function getJson($ipAddress)
    {
        $curl = curl_init();
        $url = $this->di->request->getBaseUrl() . "/apiWeather";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "ip=" . $ipAddress);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    public function indexAction()
    {
        $page = $this->di->get("page");
        $title = "Väder (REST)";

        $data = [
            "heading" => $title,
            "action" => "weatherRest/showResult",
            "type" => "weatherRest",
            "placeholder" => $_SERVER['REMOTE_ADDR'] ?? "",
        ];

        $page->add("validate/indexWeather", $data);
        return $page->render([
            "title" => $title,
        ]);
    }

    public function showResultAction()
    {
        $page = $this->di->get("page");
        $title = "Resultat väder (REST)";
        $ipAddress = $_POST["ip"];

        $data = [
            "result" => $this->getJson($ipAddress)
        ];
        
        $page->add("validate/restResult", $data);
        return $page->render([
            "title" => $title,
        ]);
    }
}
