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
    $cachedValue = LazySetting::get('cached_key');
    LazySetting::set('cached_key', 'New Value');
    $newValue = LazySetting::get('cached_key');
    expect($newValue)->toBe('New Value');
});

it('can get all settings', function () {
    LazySetting::set('site_name', 'My Website');
    LazySetting::set('site_description', 'Best website');

    $allSettings = LazySetting::get();

    expect($allSettings)->toBeArray()
        ->and($allSettings)->toHaveKey('site_name', 'My Website')
        ->and($allSettings)->toHaveKey('site_description', 'Best website');
});
