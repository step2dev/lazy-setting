<?php

use Step2Dev\LazySetting\Facades\LazySetting;

it('can get a setting', function () {
    LazySetting::set('site_name', 'My Website');
    $setting = LazySetting::get('site_name');
    expect($setting)->toBe('My Website');
});

it('can set a new setting', function () {
    LazySetting::set('site_description', 'Best website');
    $setting = LazySetting::get('site_description');
    expect($setting)->toBe('Best website');
});

it('can update an existing setting', function () {
    LazySetting::set('site_name', 'Old Name');
    LazySetting::set('site_name', 'New Name');
    $setting = LazySetting::get('site_name');
    expect($setting)->toBe('New Name');
});

it('returns default value if setting does not exist', function () {
    $setting = LazySetting::get('non_existing_key', 'Default Value');
    expect($setting)->toBe('Default Value');
});

it('validates the key and value when setting a setting', function () {
    $this->expectException(InvalidArgumentException::class);
    LazySetting::set('', 'Invalid Key');
});

it('clears the cache when setting a new value', function () {
    LazySetting::set('cached_key', 'Cached Value');
    expect(LazySetting::get('cached_key'))->toBe('Cached Value');

    LazySetting::set('cached_key', 'New Value');

    expect(LazySetting::get('cached_key'))->toBe('New Value');
});

it('can get all settings', function () {
    LazySetting::set('site_name', 'My Website');
    LazySetting::set('site_description', 'My Best website');

    $siteName = LazySetting::get('site_name');
    $siteDescription = LazySetting::get('site_description');

    expect($siteName)
        ->toBe('My Website');
    //        ->and($siteDescription)
    //        ->toBe( 'My Best website');
});

it('uses the lazy.setting config namespace', function () {
    config()->set('lazy.setting.cache_prefix', 'custom_');
    config()->set('lazy.setting.cache_ttl', 120);
    config()->set('lazy.setting.default.group', 'site');
    config()->set('lazy.setting.default.type', 'text');
    config()->set('lazy.setting.table', 'custom_settings');

    expect(Step2Dev\LazySetting\LazySetting::getCacheKey())->toBe('custom_settings')
        ->and(Step2Dev\LazySetting\LazySetting::getCacheTtl())->toBe(120)
        ->and(Step2Dev\LazySetting\LazySetting::getDefaultGroup())->toBe('site')
        ->and(Step2Dev\LazySetting\LazySetting::getDefaultType())->toBe('text')
        ->and(Step2Dev\LazySetting\LazySetting::getTable())->toBe('custom_settings');
});
