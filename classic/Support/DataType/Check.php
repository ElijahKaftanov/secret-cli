<?php declare(strict_types=1);

namespace Classic\Package\Support\DataType;

abstract class Check
{
    public static function is($value, string $type): bool
    {
        if (DataType::isValid($type)) {
            return call_user_func([__CLASS__, 'is' . ucfirst($type)], $value);
        }

        if (is_object($value)) {
            return self::isInstanceOf($value, $type);
        }

        $method = 'is' . ucfirst($type);
        if (method_exists(__CLASS__, $method)) {
            return call_user_func([__CLASS__, $method], $value);
        }

        throw new \UnexpectedValueException("Unexpected type $type");
    }

    public static function isInstanceOf(object $object, string $class): bool
    {
        return is_a($object, $class);
    }

    public static function isNotInstanceOf(object $object, string $class): bool
    {
        return !static::isInstanceOf($object, $class);
    }

    public static function isInt($value): bool
    {
        return is_int($value);
    }

    public static function isFloat($value): bool
    {
        return is_float($value);
    }

    public static function isArray($value): bool
    {
        return is_array($value);
    }

    public static function isAccessible($value): bool
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    public static function isIterable($value): bool
    {
        return is_iterable($value);
    }

    public static function isString($value): bool
    {
        return is_string($value);
    }

    public static function isResource($value): bool
    {
        return is_resource($value);
    }

    public static function isObject($value): bool
    {
        return is_object($value);
    }

    public static function isBool($value): bool
    {
        return is_bool($value);
    }

    public static function isNumeric($value): bool
    {
        return is_numeric($value);
    }

    public static function isNull($value): bool
    {
        return is_null($value);
    }

    public static function isEmpty($value): bool
    {
        return empty($value);
    }

    public static function isCallable($value): bool
    {
        return is_callable($value);
    }

    public static function isNotArray($value): bool
    {
        return !static::isArray($value);
    }

    public static function isNotNull($value): bool
    {
        return !static::isNull($value);
    }

    public static function isScalar($value): bool
    {
        return is_scalar($value);
    }
}
