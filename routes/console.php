<?php declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command(
    command: 'directories:clean',
    parameters: [
        '--path' => 'storage/app/public/avatars',
    ]
)->hourly();
