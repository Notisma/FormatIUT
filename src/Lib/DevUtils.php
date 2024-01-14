<?php

namespace App\FormatIUT\Lib;

class DevUtils
{
    /**
     * @param $v
     * @param bool $printType
     * @return void affiche la variable $v dans une balise <pre>
     */
    public static function print($v, bool $printType = false): void
    {
        echo "<pre>";
        if ($printType) var_dump($v);
        else print_r($v);
        echo "</pre>";
    }
}
