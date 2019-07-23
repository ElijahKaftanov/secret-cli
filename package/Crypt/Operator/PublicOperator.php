<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt\Operator;


use Classic\Secret\Package\Crypt\EncryptorInterface;
use Classic\Secret\Package\Crypt\SignCheckerInterface;
use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\PublicKey;

class PublicOperator implements EncryptorInterface, SignCheckerInterface
{
    private $publicKey;

    public function __construct(
        string $publicKey
    )
    {
        $this->publicKey = new PublicKey($publicKey);
    }

    public function encrypt(string $massage): string
    {
        return EasyRSA::encrypt($massage, $this->publicKey);
    }

    public function check(string $message, string $signature): bool
    {
        return EasyRSA::verify($message, $signature, $this->publicKey);
    }
}