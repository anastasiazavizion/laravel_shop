<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        if(!User::role(Role::ADMIN->value)->exists()){
            User::factory()->admin()->create();
        }

        User::factory(3)->moderator()->create();

        User::factory(5)->create();

    }
}
