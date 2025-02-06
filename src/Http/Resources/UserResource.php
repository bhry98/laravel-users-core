<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "type" => $this->Type ? TypeResource::make($this->Type) : [],
            "display_name" => $this->display_name,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "username" => $this->username,
            "email" => $this->email,
            "national_id" => $this->national_id,
            "birthdate" => $this->birthdate ? $this->birthdate->format("Y-m-d") : null,
        ];
    }
}
