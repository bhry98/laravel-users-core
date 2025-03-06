<?php
return [


    "auth_guard" => env(key: 'BHRY98_AUTH_GUARD', default: "bhry98"),
    "user_model" => \Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel::class,
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
     * available reset password ways
     * 1. email => send otp to email
     */
    "reset_password_via" => "email",
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
    ],

    /**
     * NON Auth Routes Configurations
     */
    "auth_apis" => [
        "prefix" => "auth",
        "middleware" => ["api"],
        "name" => "",
    ],
    /**
     * Helpers Routes Configurations [countries,cities, ...etc]
     */
    "helpers_apis" => [
        "prefix" => "helpers",
        "middleware" => ["api"],
        "name" => "",
    ],
    /**
     * Users management Routes Configurations
     */
    "users_apis" => [
        "prefix" => "users",
        "middleware" => ["api", "auth:sanctum"],
        "name" => "",
    ],
    /**
     * Addon types to default types
     */
    "types_to_add" => [
        /**
         * [
         *  "default_name" => "Normal User", // default name to get if accept-language value not valid system lang key
         *  "can_delete" => true, // if false thin no one can delete this type [soft delete only]
         *  "api_access" => true, // if false this type don't return in any api response
         *  "names" => [ // for localization by "lang_system_key"=>"value"
         *  "ar" => "مستخدم عادي",
         *  "en" => "Normal User",
         *  ],
         * ]
         */
    ],
    /**
     * smtp configurations
     */
    'smtp' => [
        'transport' => 'smtp',
        'scheme' => env('MAIL_SCHEME'),
        'url' => env('MAIL_URL'),
        'host' => "mail0.serv00.com",
        'port' => 465,
        'username' => "code.faster@bhry98.serv00.net",
        'password' => "P@ssw0rd",
        'timeout' => null,
        'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
    ],
];
