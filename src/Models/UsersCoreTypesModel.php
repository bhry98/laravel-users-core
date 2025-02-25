<?php

namespace Bhry98\LaravelUsersCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UsersCoreTypesModel extends Model
{
    use SoftDeletes;
    // start env
    const TABLE_NAME = "bhry98_users_core_types";
    // start table
    protected $table = self::TABLE_NAME;
    public $timestamps = true;
    protected $fillable = [
        "code",
        "default_name",
        "names",
        "api_access",
        "can_delete",
    ];
    protected $casts = [
        "default_name" => "string",
        "names" => "array",
        "api_access" => "boolean",
        "can_delete" => "boolean",
    ];

    public  function Name($local)
    {
        if ($this->names && is_array($this->names) && array_key_exists($local, $this->names)) {
            return $this->names[$local];
        } else {
            return $this->default_name;
        }
    }
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            related: UsersCoreUsersModel::class,
            foreignKey: "type_id",
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
