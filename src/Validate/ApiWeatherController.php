<?php

namespace Anax\Validate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class ApiWeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction()
    {
        // $weatherClass = new Weather();
        $weatherClass = $this->di->get("weather");
        $geoClass = new Geo();
        $ipClass = new Ip();
        $ipAddress = $_POST["ip"] ?? null;

        $resJson = $geoClass->getGeo($ipAddress);

        if (isset($resJson->loc)) {
            $resWeather = $weatherClass->getWeatherInfo($ipAddress);
            $resHistWeather = $weatherClass->getHistoricalWeatherInfo($ipAddress);

            $weatherArray = [];
            $historyArray = [];
            $resHistoryArray = [];

            foreach ($resWeather->daily as $day) {
                array_push($weatherArray, [gmdate("Y-m-d", $day->dt) => $day->weather[0]->description]);
            };

            for ($i=0; $i < 5; $i++) {
                array_push($historyArray, json_decode($resHistWeather[$i]));
            }

            foreach ($historyArray as $day) {
                array_push($resHistoryArray, [gmdate("Y-m-d", $day->current->dt) => $day->current->weather[0]->description]);
            };
        } else {
            return "Vi kunde inte hitta en plats som matchade din ip-adress. Försök igen.";
        }

        $json = [
            "ip" => $ipAddress,
            "history" => $resHistoryArray ?? "-",
            "forecast" => $weatherArray ?? "-",
            "loc" => $resJson->loc ?? "-",
            "region" => $resJson->region ?? "-",
            "city" => $resJson->city ?? "-",
            "country" => $resJson->country ?? "-",
        ];

        return [$json];
    }
}
