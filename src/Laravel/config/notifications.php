<?php

return [
    "url" => [
        "develop" => "http://msnotifications.dev",
        "stage" => "http://msnotifications.stage",
        "production" => "http://msnotifications",
        "local"=> "http://localhost:5000"
    ],
    "middleware" => [
        "web"
    ],
    "callback" => [
        "get_sharp" => null
    ]
];