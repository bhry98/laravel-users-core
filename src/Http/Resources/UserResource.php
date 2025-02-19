<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;
use Bhry98\LaravelUsersCore\Http\Resources\Helpers\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "type" => $this->Type ? TypeResource::make($this->Type) : null,
            "display_name" => $this->display_name,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "username" => $this->username,
            "email" => $this->email,
            "national_id" => $this->national_id,
            "birthdate" => $this->birthdate ? bhry98_date_formatted($this->birthdate) : null,
            "phone_number" => $this->phone_number,
            "country" =>CountryResource::make($this->whenLoaded(relationship: 'country')),
            "governorate" =>GovernorateResource::make($this->whenLoaded(relationship: 'governorate')),
            "city" =>CityResource::make($this->whenLoaded(relationship: 'city')),
        ];
    }
}
