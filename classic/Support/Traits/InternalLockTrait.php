<?php declare(strict_types=1);


namespace Classic\Package\Support\Traits;


use Classic\Package\Support\Exception\RuntimeException;

trait InternalLockTrait
{
    private $locked = false;

    protected function isLocked(): bool
    {
        return $this->locked;
    }

    protected function abortIfLocked(): void
    {
        if ($this->isLocked()) {
            $class = get_called_class();
            throw new RuntimeException("Instance of $class is locked!");
        }
    }

    protected function lock(): void
    {
        $this->locked = true;
    }

    protected function unlock(): void
    {
        $this->locked = false;
    }
}