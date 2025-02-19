<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
//            'reference_id' => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "local_name" => $this->local_name,
            "country" => $this->country ? CountryResource::make($this->country) : null,
            "governorate" => $this->governorate ? GovernorateResource::make($this->governorate) : null,
        ];
    }
}
