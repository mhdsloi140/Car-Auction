<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $slllers = [
            [
                'name' => 'Ahmad',
                'email' => 'ahd@gimal.com',
                'phone' => '0930641047',
            ],
            [
                'name' => 'Abd',
                'email' => 'abd@gimal.com',
                'phone' => '0930641074',
            ],
            [
                'name'=>'Ali Ahmad',
                'email'=>'ali@gimal.com',
                'phone'=>'0994891384'
            ]
        ];

         foreach ($slllers as $seller) {
            $user = User::create([
                'name' => $seller['name'],
                'email' => $seller['email'],
                'phone' => $seller['phone'],
                'password' => Hash::make('password'),

            ]);

            $user->assignRole('seller');
         }
    }
}
