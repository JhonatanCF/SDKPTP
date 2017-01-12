<?php

namespace JhonatanCF5;

class Str
{
    public static function studly($value)
    {
        $result = ucwords(str_replace('_', ' ', $value));
        return str_replace(' ', '', $result);
    }
}