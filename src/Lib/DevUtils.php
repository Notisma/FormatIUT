<?php

namespace App\FormatIUT\Lib;

class DevUtils
{
    public static function print($v, bool $printType = false): void
    {
        echo "<pre>";
        if ($printType) var_dump($v);
        else print_r($v);
        echo "</pre>";
    }
}
