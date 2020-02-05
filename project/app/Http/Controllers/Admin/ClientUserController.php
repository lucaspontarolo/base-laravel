<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientUserRequest;
use App\Http\Resources\Admin\ClientUserResource;
use App\Models\User;
use App\Repositories\Criterias\Common\UserRole;
use App\Repositories\UserRepository;

class ClientUserController extends Controller
{
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = ClientUserResource::class;

        $this->middleware('permission:users create client')->only(['create', 'store']);
        $this->middleware('permission:users edit client')->only(['edit', 'update']);
        $this->middleware('permission:users show client')->only(['show']);
        $this->middleware('permission:users list client')->only(['index']);
        $this->middleware('permission:users delete client')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.client.index');
    }

    public function create()
    {
        $user = new User();

        return view('admin.users.client.create', compact('user'));
    }

    public function store(ClientUserRequest $request)
    {
        $userData = $request->validated();

        $user = $this->repository->createUser($userData);
        $user->assignRole(UserRolesEnum::CLIENT);

        $message = _m('common.success.create');
        return $this->chooseReturn('success', $message, 'admin.client-users.edit', $user->id);
    }

    public function edit($id)
    {
        $user = $this->repository->findOrFail($id);

        return view('admin.users.client.edit', compact('user'));
    }

    public function update(ClientUserRequest $request, $id)
    {
        $userData = $request->validated();

        $user = $this->repository->findOrFail($id);
        $this->repository->updateUser($user, $userData);

        $message = _m('common.success.update');
        return $this->chooseReturn('success', $message, 'admin.client-users.edit', $id);
    }

    public function show($id)
    {
        $user = $this->repository->findOrFail($id);
        return view('admin.users.client.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = $this->repository->findOrFail($id);

        try {
            $this->repository->delete($user);
            return $this->chooseReturn('success', _m('common.success.destroy'));
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('common.error.destroy'));
        }
    }

    public function getPagination($pagination)
    {
        $pagination
            ->repository($this->repository)
            ->criterias([
                new UserRole(UserRolesEnum::CLIENT),
            ])
            ->defaultOrderBy('created_at', 'DESC')
            ->resource($this->resource);
    }
}
