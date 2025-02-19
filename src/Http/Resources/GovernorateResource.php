<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "name" => $this->name,
            "local_name" => $this->local_name,
            "total_cities" => $this->cities_count,
            "total_users" => $this->users_count,
            "country" => CountryResource::make($this->whenLoaded(relationship: 'country')),
        ];
    }
}
