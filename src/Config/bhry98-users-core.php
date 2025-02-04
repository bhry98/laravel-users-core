<?php
return [

    /**
     * Auth Routes Configurations
     */
    "auth_apis" => [
        "prefix" => "auth",
        "middleware" => ["web"],
        "name" => "auth",
    ],


    'users_table_name' => 'users',
    'api_prefix' => "users",
    'api_middlewares' => [
        'api'
    ],
//    "api_redirect_key" => "link"
];
