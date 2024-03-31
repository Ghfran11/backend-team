<?php

namespace App\Enum;


enum NotificationType: string
{
    case ACCEPT_ORDER = 'Accept Order';

    case EXPIRATION = 'Expiration';
}
