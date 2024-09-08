<?php

use Illuminate\Support\Facades\Artisan;
use Step2Dev\LazySetting\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

beforeEach(function () {
    Artisan::call('migrate');
});

afterEach(function () {
    Artisan::call('migrate:reset');
});
