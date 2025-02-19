<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersCoreGovernoratesModel extends Model
{
    // start env
    const TABLE_NAME = "bhry98_users_core_governorates";
    const RELATIONS = [
        "country",
    ];
    // start table
    protected $table = self::TABLE_NAME;
    public $timestamps = true;
    protected $fillable = [
        "code",
        "name",
        "local_name",
        "country_id",
    ];
    protected $casts = [
        "name" => "string",
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            related: UsersCoreCountriesModel::class,
            foreignKey: "id",
            localKey: "country_id");
    }
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            related: UsersCoreUsersModel::class,
            foreignKey: "governorate_id",
            localKey: "id");
    }
    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            related: UsersCoreCitiesModel::class,
            foreignKey: "governorate_id",
            localKey: "id");
    }

    protected static function booted(): void
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

}
