<?php

// config for Step2Dev/LazySetting
return [
    'table' => 'settings',
    'cache_prefix' => 'lazy_',
    'cache_ttl' => null, // in seconds (default: forever)
    'default' => [
        'group' => 'default',
        'type' => 'string',
        'value' => null,
        'options' => [],
        'is_encrypted' => false,
    ],
];
