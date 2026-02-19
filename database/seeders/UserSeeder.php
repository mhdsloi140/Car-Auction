<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $users=[
            [
                'name'=>'Ahmad',
                 'email'=>'ahmad@example.com',
                 'phone'=>'07812345678',
                 'password'=>Hash::make('password')
            ],
            [
                'name'=>'Ali',
                'email'=>'ali@example.com',
                'phone'=>'07701234567',
                'password'=>Hash::make('password')
            ],
            [
             'name'=>'ibrahem',
             'email'=>'ibrahem@example.com',
             'phone'=>'07509876543',
             'password'=>Hash::make('password')

            ]

        ];
        foreach($users as $user){
          $clint=  User::create([
                'name'=>$user['name'],
                'email'=>$user['email'],
                'phone'=>$user['phone'],
                'password'=>$user['password']
            ]);
             $clint->assignRole('user');


        }
    }
}
