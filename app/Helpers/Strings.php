<?php

namespace App\Helpers;

class Strings
{
    public static function onlyNumbers(string | null $string = null): string
    {
        if ($string === null) {
            return '';
        }

        return preg_replace('/\D/', '', $string);
    }
}
