<?php declare(strict_types=1);

namespace Classic\Package\Support\Tool\Dot;

use ArrayAccess;

class DotBox implements ArrayAccess
{
    /**
     * @var array|ArrayAccess $data
     */
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array|ArrayAccess $data
     * @return DotBox
     */
    public static function create($data = [])
    {
        return new self($data);
    }

    public function set(string $path, $value): void
    {
        Dot::set($this->data, $path, $value);
    }

    public function push(string $path, $value): void
    {
        Dot::push($this->data, $path, $value);
    }

    public function find(string $path, $default = null)
    {
        return Dot::find($this->data, $path, $default);
    }

    public function exists(string $path): bool
    {
        return Dot::exists($this->data, $path);
    }

    public function has(string $path): bool
    {
        return Dot::has($this->data, $path);
    }

    public function get(string $path)
    {
        return Dot::get($this->data, $path);
    }

    public function getString(string $path): string
    {
        return $this->get($path);
    }

    public function getFloat(string $path): float
    {
        return $this->get($path);
    }

    public function getOrSet(string $path, $value = null)
    {
        if ($this->exists($path)) {
            return $this->get($path);
        }

        $result = \value($value);

        $this->set($path, $result);

        return $result;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
