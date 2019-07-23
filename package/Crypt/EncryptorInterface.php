<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt;


interface EncryptorInterface
{
    public function encrypt(string $massage): string;
}