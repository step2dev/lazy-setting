<?php

// config for Step2Dev/LazySetting
return [
    'table' => 'settings',
    'cache_key' => 'cache-settings',
    'cache_ttl' => null, // in seconds (default: forever)
    'default' => [
        'group' => 'default',
        'type' => 'string',
        'value' => null,
        'options' => [],
        'is_encrypted' => false,
    ],
];
