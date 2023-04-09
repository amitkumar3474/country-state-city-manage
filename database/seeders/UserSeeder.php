<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'     => 'Amit Kumar',
            'email'    => 'amit3@gmail.com',
            'password' => Hash::make('123456')
        ];
        $roledata = User::create($data);
        $role = Role::create(['name' => 'Admin4']);

        $permissions = Permission::pluck('id','id')->all();
    
        $role->syncPermissions($permissions);
        
        $roledata->assignRole($role->name);
    }
}
