<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;

class UsersCoreSessionsModel extends Model
{
    // start env
    const TABLE_NAME = "bhry98_users_core_sessions";
    // start table
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        "user_id",
        "ip_address",
        "user_agent",
        "payload",
        "last_activity",
    ];
    protected $casts = [
        "last_activity" => "integer",
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            related: UsersCoreUsersModel::class,
            foreignKey: "id",
            localKey: "user_id");
    }
}
