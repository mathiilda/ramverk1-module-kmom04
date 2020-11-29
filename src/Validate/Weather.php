<?php

namespace mabw\Validate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Weather implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function getToken()
    {
        if (isset($_POST["test"])) {
            $path = "config/keys.php";
        } else {
            $path = "../config/keys.php";
        }

        $keys = require($path);
        $token = $keys["weather"];

        return $token;
    }

    public function getLatLon($ipAdress)
    {
        $geo = new Geo();
        $res = $geo->getGeo($ipAdress);
        $latlon = explode(",", $res->loc);

        return $latlon;
    }

    public function getWeatherInfo($ipAdress)
    {
        $latlon = $this->getLatLon($ipAdress);
        $lat = $latlon[0];
        $lon = $latlon[1];

        $token = $this->getToken();

        $curl = curl_init();
        $url = "https://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lon}&lang=se&appid=${token}";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);

        return json_decode($output);
    }

    public function getHistoricalWeatherInfo($ipAdress)
    {
        $day = time();
        $day = $day - 86400*5;
        $urls = [];

        $latlon = $this->getLatLon($ipAdress);
        $lat = $latlon[0];
        $lon = $latlon[1];

        $token = $this->getToken();

        for ($i=0; $i < 5; $i++) {
            array_push($urls, "https://api.openweathermap.org/data/2.5/onecall/timemachine?lat=${lat}&lon=${lon}&lang=se&dt=${day}&appid=${token}");

            $day = $day + 86400;
        }

        $allUrls = $urls;
        $urlCount = count($urls);
        $curlArr = array();
        $master = curl_multi_init();

        for ($i = 0; $i < $urlCount; $i++) {
            $url = $allUrls[$i];
            $curlArr[$i] = curl_init($url);
            curl_setopt($curlArr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curlArr[$i]);
        }

        do {
            curl_multi_exec($master, $running);
        } while ($running > 0);

        $results = [];

        for ($i = 0; $i < $urlCount; $i++) {
            array_push($results, curl_multi_getcontent($curlArr[$i]));
        }

        return $results;
    }
}
