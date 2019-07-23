<?php declare(strict_types=1);


namespace Classic\Package\Support\Tool;


use Academy\Package\Support\Traits\SingletonTrait;

class DeadLoop
{
    use SingletonTrait;

    /**
     * @var int
     */
    private $current = 0;

    public static function max(int $count): self
    {
        $self = static::instance();

        if (++$self->current > $count) {
            \dd();
        }

        return $self;
    }

    public function dump(...$var): self
    {
        \dump(...$var);

        return $this;
    }
}