<?php declare(strict_types=1);


namespace Classic\Package\Support\Tool;


abstract class MB
{
    public static function ucf(string $string, string $encoding = 'utf-8'): string
    {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, null, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    public static function lcf(string $string, string $encoding = 'utf-8'): string
    {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, null, $encoding);
        return mb_strtolower($firstChar, $encoding) . $then;
    }

    public static function len(string $string): int
    {
        return mb_strlen($string);
    }
}