<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $brands = [
            'Toyota',
            'Honda',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Nissan',
            'Hyundai',
            'Kia',
            'Ford',
            'Chevrolet',
        ];

          $brands = [
            'Toyota'   => 'toyota.png',
            'BMW'      => 'bmw.png',
            'Audi'     => 'audi.png',
            'Mercedes-Benz' => 'mercedes-benz.png',
            'Nissan'=>'nissan.png',
            'Kia'=>'kia.png',
            'Ford'=>'ford.png',
            'Chevrolet'=>'chevrolet.png',
            'Hyundai'=>'hyundai.png',



        ];
       foreach ($brands as $name => $logo) {

            $brand = Brand::firstOrCreate([
                'name' => $name,
            ]);

            $logoPath = public_path("img/brands/{$logo}");

            if (File::exists($logoPath) && ! $brand->hasMedia('logo')) {
                $brand
                    ->addMedia($logoPath)
                    ->preservingOriginal()
                    ->toMediaCollection('logo');
            }
        }
    }
}
