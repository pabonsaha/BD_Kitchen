<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['Customer','Admin', 'Kitchen'];
        foreach ($roles as $value) {
            $role = new Role();
            $role->name = $value;
            $role->permissions = json_encode([]);
            $role->type = 0;
            $role->save();
        }
    }
}
