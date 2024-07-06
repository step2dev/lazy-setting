<?php

// config for Step2Dev/LazySetting
return [
    'table'     => 'settings',
    'cache_key' => 'cache-settings',
    'cache_ttl' => 60 * 60 * 24,
    'default'   => [
        'group'        => 'string',
        'type'         => 'text',
        'value'        => null,
        'is_protected' => false,
        'is_encrypted' => false,
        'deletable'    => true,
    ],
];
