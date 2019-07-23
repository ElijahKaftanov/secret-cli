<?php declare(strict_types=1);

namespace Classic\Package\Support\Traits;


trait StaticCreateTrait
{
    /**
     * @return $this
     */
    public static function create(): self
    {
        return new static();
    }
}