<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientUserResource extends JsonResource
{
    public function toArray($request)
    {
        $user = current_user();

        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => format_date($this->created_at),
            'links' => [
                'edit' => $this->when(
                    $user->can('users edit client'),
                    route('admin.client-users.edit', $this->id)
                ),
                'show' => $this->when(
                    $user->can('users show client'),
                    route('admin.client-users.show', $this->id)
                ),
                'destroy' => $this->when(
                    $user->can('users delete client'),
                    route('admin.client-users.destroy', $this->id)
                ),
            ],
        ];
    }
}
