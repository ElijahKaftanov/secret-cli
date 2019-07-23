<?php declare(strict_types=1);


namespace Academy\Package\Support\Traits;


trait SingletonTrait
{
    protected static $instance;

    protected function __construct()
    {
    }

    private function __wakeup()
    {
    }

    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}