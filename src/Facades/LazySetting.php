<?php

namespace Step2Dev\LazySetting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Step2Dev\LazySetting\LazySetting
 */
class LazySetting extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Step2Dev\LazySetting\LazySetting::class;
    }
}
