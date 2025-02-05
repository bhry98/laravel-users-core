<?php

namespace Bhry98UsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UsersCoreUsersModel extends User implements JWTSubject
{
    // start env
    const TABLE_NAME = "bhry98_users_core_types";
    // start table
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        "code",
        "type_id",
        "display_name",
        "first_name",
        "last_name",
        "username",
        "email",
        "email_verified_at",
        "password",
    ];
    protected $casts = [
        "email_verified_at" => "datetime",
        "password" => "hashed",
        "remember_token" => "string",
        "code" => "uuid",
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "deleted_at" => "datetime",
    ];

    public function extraColumns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            related: UsersCoreExtraValuesModel::class,
            foreignKey: "core_user_id",
            localKey: "id");
    }

    protected static function boot(): void
    {
        static::creating(function ($model) {
            // create new unique code
            $model->code = self::generateNewCode();
        });
    }

    static function generateNewCode(): string
    {
        $code = Str::uuid();
        if (static::where('code', $code)->exists()) {
            return self::generateNewCode();
        }
        return $code;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

}
