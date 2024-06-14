<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

return [
    'events' => [

    ],
    'google-play' => [
        'package_name' => '',
        'application_credentials' => ''

    ],
    'app-store' => [
        'sandbox' => env('APPLE_SANDBOX', is_dev_env(true)),
        // password
        'password' => ''
    ]
];
