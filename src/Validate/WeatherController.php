<?php

namespace Anax\Validate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction()
    {
        $page = $this->di->get("page");
        $title = "Väder";

        $data = [
            "heading" => $title,
            "action" => "weather/showResult",
            "type" => null
        ];

        $page->add("validate/indexWeather", $data);
        return $page->render([
            "title" => $title,
        ]);
    }

    public function showResultAction()
    {
        $page = $this->di->get("page");
        $title = "Resultat väder";
        $ipAdress = $_POST["ip"];

        $geoClass = new Geo();
        $ipClass = new Ip();

        $resJson = $geoClass->getGeo($ipAdress);

        if ($ipClass->getIpInfo($ipAdress)[0] == "Ip-adressen är inte giltig.") {
            $error = true;
        } else if (isset($resJson->loc)) {
            $weatherClass = $this->di->get("weather");
            $resWeather = $weatherClass->getWeatherInfo($ipAdress);
            $resHistWeather = $weatherClass->getHistoricalWeatherInfo($ipAdress);
            $resJson = $geoClass->getGeo($ipAdress);
            $newHist = [];

            for ($i=0; $i < 5; $i++) {
                array_push($newHist, json_decode($resHistWeather[$i]));
            }

            $latlon = explode(",", $resJson->loc);
        }

        $data = [
            "error" => $error ?? false,
            "forecast" => $resWeather->daily ?? "error",
            "historical" => $newHist ?? "error",
            "region" => $resJson->region ?? "-",
            "city" => $resJson->city ?? "-",
            "country" => $resJson->country ?? "-",
            "loc" => $resJson->loc ?? "-",
            "lat" => $latlon[0] ?? null,
            "lon" => $latlon[1] ?? null,
        ];

        $page->add("validate/weatherResult", $data);
        return $page->render([
            "title" => $title,
        ]);
    }
}
