<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'users' => [
            'create admin',
            'edit admin',
            'show admin',
            'list admin',
            'delete admin',
            'create client',
            'edit client',
            'show client',
            'list client',
            'delete client',
        ],

        'profile' => [
            'edit admin',
        ],
    ],

    UserRolesEnum::CLIENT => [
        'profile' => [
            'edit client',
        ],
    ],
];
