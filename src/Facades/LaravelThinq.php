<?php

namespace R64\LaravelThinq\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelThinq extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelthinq';
    }
}
