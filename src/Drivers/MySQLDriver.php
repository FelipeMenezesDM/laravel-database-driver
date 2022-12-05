<?php

namespace FelipeMenezesDM\LaravelDatabaseDriver\Drivers;

class MySQLDriver extends Driver
{
    /**
     * Get constant to print current timestamp
     *
     * @return string
     */
    public function currentTimestamp() : string
    {
        return 'utc_timestamp';
    }
}
