<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;

class UsersCorePersonalAccessToken extends PersonalAccessToken
{
    // start env
    const TABLE_NAME = "bhry98_users_core_tokens";
    // start table
    protected $table = self::TABLE_NAME;
}