<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class BuyersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $buyers = [
            [
                'name' => 'Ahmad',

                'phone' => '7701234561',
            ],
            [
                'name' => 'Abd',

                'phone' => '7812345679',
            ],
            [
                'name'=>'Ali Ahmad',

                'phone'=>'7509876542'
            ]
        ];

         foreach ($buyers as $buyer) {
            $user = User::create([
                'name' => $buyer['name'],
            
                'phone' => $buyer['phone'],
                'password' => Hash::make('password'),

            ]);

            $user->assignRole('buyer');
         }
    }
}
