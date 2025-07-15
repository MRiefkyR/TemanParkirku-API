<?php

return [

    

   'defaults' => [
    'guard' => 'admin',
    'passwords' => 'admins',
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'penggunas',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'penggunas' => [
        'driver' => 'eloquent',
        'model' => App\Models\Pengguna::class,
    ],
],

'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
    'admins' => [
        'provider' => 'admins',
        'table' => 'admins_password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
    'penggunas' => [
        'provider' => 'penggunas',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
],
];