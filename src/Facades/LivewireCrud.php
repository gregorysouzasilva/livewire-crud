<?php

namespace Gregorysouzasilva\LivewireCrud\Facades;

use Illuminate\Support\Facades\Facade;

class LivewireCrud extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'crud';
    }
}
