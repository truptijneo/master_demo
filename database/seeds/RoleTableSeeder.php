<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->guard_name = 'A Admin User';
        $role_admin->save();

        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->guard_name = 'A Customer User';
        $role_user->save();
    }
}
