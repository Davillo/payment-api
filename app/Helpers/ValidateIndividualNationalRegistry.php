<?php

namespace App\Helpers;

class ValidateIndividualNationalRegistry
{
    const INDIVIDUAL_NATIONAL_REGISTRY_DEFAULT_SIZE = 11;

    public static function validate($value): bool
    {
        if (self::hasInvalidSize($value)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $value[$i++] * $s--) {
        }

        if ($value[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $value[$i++] * $s--) {
        }

        if ($value[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    private static function hasInvalidSize($value): bool
    {
        return strlen($value) <> 11 || preg_match("/^{$value[0]}{11}$/", $value);
    }

}
