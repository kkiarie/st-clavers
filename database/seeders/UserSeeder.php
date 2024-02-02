<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            
            'name' => 'Parent',
            'email' => 'parent@mail.com',
            'status' => 0,
            'user_role' => 4,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);



        DB::table('users')->insert([
            
            'name' => 'Teacher',
            'email' => 'teacher@mail.com',
            'status' => 0,
            'user_role' => 2,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

         DB::table('users')->insert([
            
            'name' => 'Lecturer',
            'email' => 'lecturer@mail.com',
            'status' => 0,
            'user_role' => 2,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);



        DB::table('users')->insert([
            
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'status' => 0,
            'user_role' => 1,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            
            'name' => 'Admin',
            'email' => 'admin@softui.com',
            'status' => 0,
            'user_role' => 1,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);




        DB::table('users')->insert([
            
            'name' => 'Student',
            'email' => 'student@mail.com',
            'status' => 0,
            'user_role' => 3,
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);


        DB::table('settings')->insert([
            'title' => Str::random(10),
        ]);

    }
}
