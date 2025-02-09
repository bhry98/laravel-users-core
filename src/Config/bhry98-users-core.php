<?php
return [


    "auth_guards" => env(key: 'BHRY98_AUTH_GUARDS', default: "bhry98"),
    "date" => [
        'format' => 'd-m-Y  h:i A',
        'format_time' => 'H:i A',
        'format_notification' => 'd-M h:i A',
        'format_without_time' => 'd-m-Y',
    ],
    /**
     * available login ways
     * 1. username => login via username &password
     *
     */
    "login_via" => "username",
//
//    /**
//     * Auth Routes Configurations
//     */
//    "auth_apis" => [
//        "prefix" => "auth",
//        "middleware" => ["web"],
//        "name" => "auth",
//    ],
//
//
//    'users_table_name' => 'users',
//    'api_prefix' => "users",
//    'api_middlewares' => [
//        'api'
//    ],
//    "api_redirect_key" => "link"
];
