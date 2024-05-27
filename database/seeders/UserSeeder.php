<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(9)->create();
        foreach ($users as $user){
         $user->assignRole('user');
        }
        $users = User::factory(1)->create([
            'firstName'=>'admin',
            'lastName'=>'admin',
            'email'=>'admin@admin.ch'
           ]);
           foreach ($users as $user){
            $user->assignRole('admin');
           }
    }
}
