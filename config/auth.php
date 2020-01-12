<?php
return [
  'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
  ],
  'guards' => [
    'web' => [
      'driver' => 'session',
      'provider' => 'users',
    ],
    'api' => [
      'driver' => 'token',
      'provider' => 'users',
    ],
    'admin' => [
      'driver' => 'session',
      'provider' => 'admin',
    ],
    'admin-api' => [
      'driver' => 'token',
      'provider' => 'admin',
    ],
    'siswa' => [
      'driver' => 'session',
      'provider' => 'siswa',
    ],
    'siswa-api' => [
      'driver' => 'token',
      'provider' => 'siswa',
    ],
  ],
  'providers' => [
    'users' => [
      'driver' => 'eloquent',
      'model' => App\User::class,
    ],
    'admin' => [
      'driver' => 'eloquent',
      'model' => App\Admin::class,
    ],
    'siswa' => [
      'driver' => 'eloquent',
      'model' => App\siswa::class,
    ],
  ],
  'passwords' => [
    'users' => [
      'provider' => 'users',
      'table' => 'password_resets',
      'expire' => 60,
    ],
    'admin' => [
      'provider' => 'admin',
      'table' => 'password_resets',
      'expire' => 60,
    ],
    'siswa' => [
      'provider' => 'siswa',
      'table' => 'password_resets',
      'expire' => 60,
    ],
  ],
];
