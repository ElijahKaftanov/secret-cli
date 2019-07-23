<?php declare(strict_types=1);


namespace Classic\Package\Support\Traits;


trait MemoryTrait
{
    private $_memory = [];

    protected function memory(string $key, $value = null)
    {
        if (!isset($this->_memory[$key])) {
            return $this->_memory[$key] = \value($value);
        }

        return $this->_memory[$key];
    }

    protected function memoryReset()
    {
        $this->_memory = [];
    }
}