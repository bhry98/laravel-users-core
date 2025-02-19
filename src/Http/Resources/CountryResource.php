<?php

namespace Bhry98\LaravelUsersCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "country_code" => $this->country_code,
            "name" => $this->name,
            "local_name" => $this->local_name,
            "flag" => $this->flag,
            "lang_key" => $this->lang_key,
            "system_lang" => $this->system_lang,
            "total_users" => $this->users_count,
            "total_governorates" => $this->governorates_count,
            "total_cities" => $this->cities_count,
        ];
    }
}
