<?php
return [


    "auth_guard" => env(key: 'BHRY98_AUTH_GUARD', default: "bhry98"),
    "date" => [
        'format' => 'd-m-Y  h:i A',
        'format_time' => 'H:i A',
        'format_notification' => 'd-M h:i A',
        'format_without_time' => 'd-m-Y',
    ],
    /**
     * available login ways
     * 1. username => login via username & password
     * 2. phone => login via phone number & password
     */
    "login_via" => "phone",
    /**
     * available overwrite validation for core user table
     */
    "validations" => [
        "phone_number" => [
            "required" => true,
        ],
        "national_id" => [
            "required" => false,
        ],
        /**
         * addon validations
         */
        "users_core_table" => [],
    ]
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
