<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersCoreCountriesModel extends Model
{
    // start env
    const TABLE_NAME = "bhry98_users_core_countries";
    // start table
    protected $table = self::TABLE_NAME;
    public $timestamps = true;
    protected $fillable = [
        "code",
        "country_code",
        "name",
        "local_name",
        "flag",
        "lang_key",
        "timezone",
        "system_lang",
    ];
    protected $casts = [
        "name" => "string",
        "system_lang" => "boolean",
    ];
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            related: UsersCoreUsersModel::class,
            foreignKey: "country_id",
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
