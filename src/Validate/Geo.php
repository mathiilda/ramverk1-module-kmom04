<?php

namespace mabw\Validate;

class Geo
{
    public function getGeo($ipAddress)
    {
        if (isset($_POST["test"])) {
            $path = "config/keys.php";
        } else {
            $path = "../config/keys.php";
        }

        $keys = require($path);
        $token = $keys["geo"];

        $curl = curl_init();
        $url = "https://ipinfo.io/${ipAddress}/json?token=${token}";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);

        return json_decode($output);
    }
}
