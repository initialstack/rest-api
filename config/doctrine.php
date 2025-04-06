<?php declare(strict_types=1);

use Ramsey\Uuid\Doctrine\UuidType;

return [
    'connection' => [
        'driver' => 'pdo_pgsql',
        'host' => env('DB_HOST', 'postgres'),
        'port' => env('DB_PORT', '5432'),
        'dbname' => env('DB_DATABASE', 'database'),
        'user' => env('DB_USERNAME', 'user'),
        'password' => env('DB_PASSWORD', 'password'),
        'options' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ],
    ],
    'metadata_dirs' => [
        app_path(path: 'Entities'),
    ],
    'custom_types' => [
        UuidType::NAME => UuidType::class,
    ],
    'dev_mode' => true
];
