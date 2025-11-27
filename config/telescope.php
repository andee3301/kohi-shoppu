<?php

return [
    'domain' => env('TELESCOPE_DOMAIN'),
    'path' => env('TELESCOPE_PATH', 'telescope'),
    'middleware' => ['web', 'auth'],
    'only_paths' => [
        'app/*',
        'resources/views/*',
        'routes/*',
    ],
    'ignore_paths' => [
        'vendor/*',
    ],
    'watchers' => [],
];
