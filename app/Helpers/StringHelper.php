<?php

namespace App\Helpers;

class StringHelper
{
    public static function sanitize(string $value): string
    {
        return preg_replace('/[^\d]/', '', $value);
    }
}
