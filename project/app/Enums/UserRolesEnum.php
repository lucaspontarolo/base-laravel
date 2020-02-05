<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self ADMIN()
 * @method static self CLIENT()
 */
class UserRolesEnum extends Enum
{
    public const ADMIN = 'admin';
    public const CLIENT = 'client';
}
