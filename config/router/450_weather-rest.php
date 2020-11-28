<?php
/**
 * Validate ip
 */
return [
    "routes" => [
        [
            "info" => "Get weather (REST).",
            "mount" => "weatherRest",
            "handler" => "\Anax\Validate\WeatherRESTController",
        ],
    ]
];
