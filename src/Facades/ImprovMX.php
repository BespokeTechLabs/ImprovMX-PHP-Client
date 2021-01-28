<?php

namespace Bespoke\ImprovMX\Facades;

use Illuminate\Support\Facades\Facade;

class ImprovMX extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'improvmx';
    }
}
