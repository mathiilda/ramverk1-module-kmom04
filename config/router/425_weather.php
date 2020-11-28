<?php
/**
 * Validate ip
 */
return [
    "routes" => [
        [
            "info" => "Get weather.",
            "mount" => "weather",
            "handler" => "\Anax\Validate\WeatherController",
        ],
    ]
];
