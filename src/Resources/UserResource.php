<?php

namespace Bhry98UsersCore\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
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
    }
}
