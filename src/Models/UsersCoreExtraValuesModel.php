<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;

class UsersCoreExtraValuesModel extends Model
{
    // start env
    const TABLE_NAME = "bhry98_users_core_extra_values";
    // start table
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        "column_id",
        "core_user_id",
        "value",
    ];

    public function CoreUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            related: UsersCoreUsersModel::class,
            foreignKey: "id",
            localKey: "core_user_id"
        );
    }

    public function CoreType(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            related: UsersCoreExtraColumnsModel::class,
            foreignKey: "id",
            localKey: "column_id"
        );
    }

}
