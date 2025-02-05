<?php

namespace Bhry98UsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersCoreTypesModel extends Model
{

    // start env
    const TABLE_NAME = "bhry98_users_core_users";
    // start table
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        "code",
        "default_name",
        "names",
    ];
    protected $casts = [
        "code" => "uuid",
        "default_name" => "string",
        "names" => "array",
    ];

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

}
