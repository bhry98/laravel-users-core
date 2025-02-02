<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersCoreExtraColumnsModel extends Model
{
    // start env
    const TABLE_NAME = "users_core_extra_columns";
    // start table
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        "code",
        "type_id",
        "defualt_input_name",
        "input_names",
        "validation"
    ];
    protected $casts = [
        "code" => "uuid",
        "input_names" => "array",
        "validation" => "array",

    ];

    public function Type(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            related: UsersCoreTypesModel::class,
            foreignKey: "id",
            localKey: "type_id"
        );
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
}
