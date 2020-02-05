<?php

use App\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrNew([
            'email' => 'admin@email.com.br',
        ]);

        $user->fill([
            'name' => 'Administrador',
            'email' => 'admin@email.com.br',
            'password' => \Hash::make('123456')
        ]);

        $user->save();
        $user->assignRole(UserRolesEnum::ADMIN);
    }
}
