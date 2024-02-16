<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'users',
                'name_ar' => 'المستخدمين',
            ],
            [
                'name' => 'coupons',
                'name_ar' => 'الكوبونات',
            ],
            [
                'name' => 'accounts',
                'name_ar' => 'البروفايلات',
            ],
            [
                'name' => 'settings',
                'name_ar' => 'الاعدادات',
            ],
            [
                'name' => 'complains',
                'name_ar' => 'الشكاوى',
            ]
        ];
        /** @var Role $role */
        $role = Role::query()->firstOrCreate([
            'name' => 'admin'
        ]);
        foreach ($permissions as $permission) {
            $permission = Permission::query()->updateOrCreate([
                'name' => $permission['name']
            ], [
                'name_ar' => $permission['name_ar']
            ]);
            $role->givePermissionTo($permission);
        }
        /** @var User $user */
        $user = User::first();
        $user->assignRole($role);
    }
}
