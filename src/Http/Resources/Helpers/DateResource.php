<?php

namespace Bhry98\LaravelUsersCore\Http\Resources\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "formated" => $this->date,
        ];
    }
}
