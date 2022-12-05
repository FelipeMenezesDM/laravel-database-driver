<?php

namespace FelipeMenezesDM\LaravelDatabaseDriver\Drivers;

abstract class Driver
{
    private static $instance;

    /**
     * Singleton pattern
     *
     * @return Driver
     */
    public static function getInstance() : Driver
    {
        if(self::$instance === null) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /** @Override */
    public function currentTimestamp() : string
    {
        return 'current_timestamp';
    }
}
