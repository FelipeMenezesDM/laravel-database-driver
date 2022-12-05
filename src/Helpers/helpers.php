<?php

if(!function_exists('driver')) {
    function driver() : FelipeMenezesDM\LaravelDatabaseDriver\Drivers\Driver
    {
        return FelipeMenezesDM\LaravelDatabaseDriver\Enums\DefaultDriversEnum::tryFrom(getenv('DB_CONNECTION'))->getDriver();
    }
}