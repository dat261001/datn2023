<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $user = User::first();
        // foreach($user as $a){
        //     $a->syncRoles(2);
        // }
        // $role = Role::create(['name' => 'Admin']);
        // $role1 = Role::create(['name' => 'User']);
        // $role2 = Role::create(['name' => 'Manager']);
         $user->syncRoles(1);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
