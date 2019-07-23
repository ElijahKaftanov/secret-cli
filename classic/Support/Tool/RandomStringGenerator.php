<?php declare(strict_types=1);


namespace Classic\Package\Support\Tool;


use Classic\Package\Support\Exception\UnexpectedValueException;
use Classic\Package\Support\Traits\StaticCreateTrait;

class RandomStringGenerator
{
    use StaticCreateTrait;

    private $space = '';

    public function lowercaseEnglishCharacters(): self
    {
        $this->space .= 'abcdefghijklmnopqrstuvwxyz';

        return $this;
    }

    public function uppercaseEnglishCharacters(): self
    {
        $this->space .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return $this;
    }

    public function englishCharacters(): self
    {
        $this->lowercaseEnglishCharacters();
        $this->uppercaseEnglishCharacters();

        return $this;
    }

    public function digits(): self
    {
        $this->space .= '0123456789';

        return $this;
    }

    public function generate(int $length): string
    {
        return self::make($length, $this->space);
    }

    public static function make(int $length, string $space)
    {
        if ($length <= 0) {
            throw UnexpectedValueException::supplied($length);
        }

        $pieces = [];
        $max = mb_strlen($space, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $space[mt_rand(0, $max)];
        }
        return implode('', $pieces);
    }
}