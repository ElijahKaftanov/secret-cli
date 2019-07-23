<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt;


interface DecryptorInterface
{
    public function decrypt(string $message): string;
}