<?php

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('obj')) {
    /**
     * Return object
     *
     * @param array $data
     * @return object
     */
    function obj(array $data = []) {
        return (object)$data;
    }
}
