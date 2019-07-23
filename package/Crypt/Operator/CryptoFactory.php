<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt\Operator;


use Classic\Secret\Package\Crypt\DecryptorInterface;

class CryptoFactory
{
    public function makeEncryptor(string $publicKey)
    {
        return new PublicOperator($publicKey);
    }

    public function makeDecryptor(string $privateKey): DecryptorInterface
    {
        return new PrivateOperator($privateKey);
    }

    public function makeSignChecker(string $publicKey)
    {
        return new PublicOperator($publicKey);
    }

    public function makeSigner(string $privateKey)
    {
        return new PrivateOperator($privateKey);
    }
}