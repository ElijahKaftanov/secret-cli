<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt\Operator;


use Classic\Secret\Package\Crypt\DecryptorInterface;
use Classic\Secret\Package\Crypt\SignerInterface;
use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\PrivateKey;

class PrivateOperator implements DecryptorInterface, SignerInterface
{
    /**
     * @var string
     */
    private $privateKey;

    public function __construct(
        string $privateKey
    )
    {
        $this->privateKey = new PrivateKey($privateKey);
    }

    public function decrypt(string $message): string
    {
        return EasyRSA::decrypt($message, $this->privateKey);
    }

    public function sign(string $message): string
    {
        return EasyRSA::sign($message, $this->privateKey);
    }
}