<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Http\Resources\Admin\AdminUserResource;
use App\Repositories\Criterias\Common\UserRole;
use App\Repositories\UserRepository;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = AdminUserResource::class;

        $this->middleware('permission:users create admin')->only(['create', 'store']);
        $this->middleware('permission:users edit admin')->only(['edit', 'update']);
        $this->middleware('permission:users show admin')->only(['show']);
        $this->middleware('permission:users list admin')->only(['index']);
        $this->middleware('permission:users delete admin')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.admin.index');
    }

    public function create()
    {
        return view('admin.users.admin.create');
    }

    public function store(AdminUserRequest $request)
    {
        $userData = $request->validated();

        $user = $this->repository->createUser($userData);
        $user->assignRole(UserRolesEnum::ADMIN);

        $message = _m('common.success.create');
        return $this->chooseReturn('success', $message, 'admin.admin-users.edit', $user->id);
    }

    public function edit($id)
    {
        $user = $this->repository->findOrFail($id);
        return view('admin.users.admin.edit', compact('user'));
    }

    public function update(AdminUserRequest $request, $id)
    {
        $userData = $request->validated();

        $user = $this->repository->findOrFail($id);
        $this->repository->updateUser($user, $userData);

        $message = _m('common.success.update');
        return $this->chooseReturn('success', $message, 'admin.admin-users.edit', $id);
    }

    public function show($id)
    {
        $user = $this->repository->findOrFail($id);
        return view('admin.users.admin.show', compact('user'));
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
            ->criterias(new UserRole(UserRolesEnum::ADMIN))
            ->defaultOrderBy('created_at', 'DESC')
            ->resource($this->resource);
    }
}
