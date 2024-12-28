<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array('Admin', 'Vendor', 'User');

        foreach ($roles as $role){
            Role::create(['name' => $role]);
        }
    }
}
