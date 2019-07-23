<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt;


interface SignCheckerInterface
{
    public function check(string $message, string $signature): bool;
}