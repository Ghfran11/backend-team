<?php

namespace App\Enum;


enum NotificationType: string
{
    case MESSAGE = 'Message';
    case WELCOME = 'Welcome';
    case EXPIRATION = 'Expiration';
}
