<?php

use App\Helpers\PermissionsHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = $this->getPermissions();
        $flattenPermissions = PermissionsHelper::getFlattenPermissions($permissions);
        $permissionBD = DB::table('permissions')->get('name')->pluck('name')->all();

        $this->createPermissions($flattenPermissions, $permissionBD);
        $this->dropUnsettledPermissions($flattenPermissions, $permissionBD);
    }

    private function getPermissions()
    {
        return config('permissions');
    }

    private function createPermissions($flattenPermissions, $permissionBD)
    {
        $permissions = array_diff($flattenPermissions, $permissionBD);
        foreach ($permissions as $permission) {
            $model = Permission::firstOrNew(['name' => $permission]);
            $model->save();
        }
    }

    private function dropUnsettledPermissions($flattenPermissions, $permissionBD)
    {
        $permissions = array_diff($permissionBD, $flattenPermissions);
        Permission::whereIn('name', $permissions)->delete();
    }
}
