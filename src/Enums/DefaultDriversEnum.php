<?php

namespace FelipeMenezesDM\LaravelDatabaseDriver\Enums;

use FelipeMenezesDM\LaravelDatabaseDriver\Drivers\Driver;
use FelipeMenezesDM\LaravelDatabaseDriver\Drivers\MySQLDriver;
use FelipeMenezesDM\LaravelDatabaseDriver\Drivers\PostgreSQLDriver;
use FelipeMenezesDM\LaravelDatabaseDriver\Drivers\SQLiteDriver;
use FelipeMenezesDM\LaravelDatabaseDriver\Drivers\SQLServerDriver;

enum DefaultDriversEnum : string
{
    case MySQL = 'mysql';
    case PostgreSQL = 'postgres';
    case SQLServer = 'sqlserver';
    case SQLite = 'sqlite';

    /**
     * Get Driver object singleton
     *
     * @return Driver
     */
    public function getDriver() : Driver
    {
        return match($this) {
            self::MySQL => MySQLDriver::getInstance(),
            self::PostgreSQL => PostgreSQLDriver::getInstance(),
            self::SQLServer => SQLServerDriver::getInstance(),
            self::SQLite => SQLiteDriver::getInstance(),
        };
    }
}
