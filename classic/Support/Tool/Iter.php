<?php declare(strict_types=1);

namespace Classic\Package\Support\Tool;

abstract class Iter
{
    /**
     * @param iterable|array $iterable
     * @param callable $callback
     * @return array
     */
    public static function map(iterable $iterable, callable $callback): array
    {
        $result = [];
        foreach ($iterable as $key => $value) {
            $result[] = call_user_func($callback, $value, $key);
        }

        return $result;
    }

    /**
     * @param iterable|array $iterable
     * @param callable $callback
     * @return array
     */
    public static function filter(iterable $iterable, callable $callback = null): array
    {
        $result = [];
        foreach ($iterable as $key => $value) {
            if (call_user_func($callback, $value, $key) === true) {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * @param iterable $iterable
     * @param mixed $initial
     * @param callable $callback
     * @return mixed
     */
    public static function reduce(iterable $iterable, $initial, callable $callback)
    {
        foreach ($iterable as $key => $value) {
            $initial = call_user_func($callback, $initial, $value, $key);
        }

        return $initial;
    }

    public static function toArray(iterable $iterator): array
    {
        $result = [];
        foreach ($iterator as $key => $item) {
            $result[$key] = $item;
        }
        return $result;
    }

    public static function count(iterable $iterable): int
    {
        if (is_countable($iterable)) {
            return \count($iterable);
        }

        $count = 0;
        foreach ($iterable as $value) {
            ++$count;
        }

        return $count;
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param iterable $iterable
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public static function first(iterable $iterable, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($iterable)) {
                return \value($default);
            }

            foreach ($iterable as $item) {
                return $item;
            }

            return \value($default);
        }

        foreach ($iterable as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return \value($default);
    }
}