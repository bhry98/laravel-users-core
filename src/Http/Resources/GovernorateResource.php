<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
//            'reference_id' => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "local_name" => $this->local_name,
            "total_cities" => $this->cities_count,
//            "country" => $this->when(in_array("countries", $request->with)) ? ($this->country ? CountryResource::make($this->country) : null) : null,
            "country" => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
