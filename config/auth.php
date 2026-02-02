<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'penggunas',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'penggunas',
        ],
        
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'penggunas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pengguna::class,
        ],
        
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'penggunas' => [
            'provider' => 'penggunas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];