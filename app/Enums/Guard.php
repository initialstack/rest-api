<?php declare(strict_types=1);

namespace App\Enums;

enum Guard: string
{
    /**
     * The API guard for authenticating API requests.
     */
    case API = 'api';

    /**
     * The web guard for authenticating web requests.
     */
    case WEB = 'web';
}
