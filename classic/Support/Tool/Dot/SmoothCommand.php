<?php declare(strict_types=1);


namespace Classic\Package\Support\Tool\Dot;


class SmoothCommand
{
    private $result = [];

    public static function execute($value)
    {
        $instance = new self();

        $instance->calculate($value);

        return $instance->result;
    }

    private function calculate($data, string $prefix = '')
    {
        foreach ($data as $key => $value) {
            $path = $prefix . $key;
            if (is_iterable($value)) {
                $this->calculate($value, $path . '.');
            } else {
                $this->result[$path] = $value;
            }
        }
    }
}