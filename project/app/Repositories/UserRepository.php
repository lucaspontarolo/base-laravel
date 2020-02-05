<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    protected function getClass()
    {
        return User::class;
    }

    public function createUser($data)
    {
        $data = $this->password($data);

        return parent::create($data);
    }

    public function updateUser($id, $data)
    {
        $data = $this->password($data);
        $model = $this->returnOrFindModel($id);

        $model->fill($data);
        $model->save();

        return $model;
    }

    protected function password($data)
    {
        $data['password'] = $data['password'] ?? null;
        if ($data['password'] === null) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } else {
            $data['password'] = \Hash::Make($data['password']);
        }

        return $data;
    }
}
