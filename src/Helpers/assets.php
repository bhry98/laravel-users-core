<?php

if (!function_exists(function: 'bhry98_date_formatted')) {
    function bhry98_date_formatted(string $date = ''): array
    {
        return [
            "iso" => $date,
            "formatted_date" => $date?->format("d M Y") ?? null,
        ];
    }
}

