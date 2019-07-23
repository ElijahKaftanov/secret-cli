<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt;


interface SignerInterface
{
    public function sign(string $message): string;
}