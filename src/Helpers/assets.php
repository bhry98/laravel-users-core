<?php

if (!function_exists(function: 'bhry98_date_formatted')) {
    function bhry98_date_formatted($date = ''): array
    {
        return [
            "iso" => $date,
            'format' => $date?->format(config(key: "bhry98-users-core.date.format")) ?? null,
            'format_time' => $date?->format(config(key: "bhry98-users-core.date.format_time")) ?? null,
            'format_notification' => $date?->format(config(key: "bhry98-users-core.date.format_notification")) ?? null,
            'format_without_time' => $date?->format(config(key: "bhry98-users-core.date.format_without_time")) ?? null,
        ];
    }
}

