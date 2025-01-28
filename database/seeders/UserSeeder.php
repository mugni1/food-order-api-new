<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // User::truncate();
        // Schema::enableForeignKeyConstraints();
        
        $users = [
            ['name' => 'kingudin', 'email' => 'manager@example.com', 'password' => 12345678 ,'role_id' => 1],
            ['name' => 'budi', 'email' => 'waiter@example.com', 'password' => 12345678 ,'role_id' => 2],
            ['name' => 'agus', 'email' => 'chef@example.com', 'password' => 12345678 ,'role_id' => 3],
            ['name' => 'asep', 'email' => 'cashier@example.com', 'password' => 12345678 ,'role_id' => 4],
        ];

        collect($users)->map(function ($user){
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role_id' => $user['role_id'],
            ]);
        });
    }
}