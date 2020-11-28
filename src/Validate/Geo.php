<?php

namespace Anax\Validate;

class Geo
{
    public function getGeo($ipAddress)
    {
        if (file_exists("../config/keys.php")) {
            $keys = require("../config/keys.php");
            $token = $keys["geo"];
        } else {
            $token = file_get_contents("token.txt", FILE_USE_INCLUDE_PATH);
        }

        $curl = curl_init();
        $url = "https://ipinfo.io/${ipAddress}/json?token=${token}";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);

        return json_decode($output);
    }
}
