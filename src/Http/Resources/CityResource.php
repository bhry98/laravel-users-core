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
            "country" => CountryResource::make($this->whenLoaded("country")),
            "governorate" => GovernorateResource::make($this->whenLoaded("governorate")),
        ];
    }
}
