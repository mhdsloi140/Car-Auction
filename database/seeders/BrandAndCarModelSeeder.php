<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\CarModel;

class BrandAndCarModelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Hilux', 'Yaris', 'Land Cruiser'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Fit', 'HR-V'],
            'BMW' => ['3 Series', '5 Series', '7 Series', 'X3', 'X5', 'i8'],
            'Mercedes' => ['C-Class', 'E-Class', 'S-Class', 'GLA', 'GLE', 'A-Class'],
            'Ford' => ['Focus', 'Fiesta', 'Mustang', 'Explorer', 'F-150', 'EcoSport'],
            'Audi' => ['A3', 'A4', 'A6', 'Q3', 'Q5', 'Q7'],
            'Nissan' => ['Sentra', 'Altima', 'Maxima', 'X-Trail', 'Qashqai', 'GT-R'],
            'Kia' => ['Rio', 'Cerato', 'Sportage', 'Sorento', 'Picanto', 'K5'],
            'Hyundai' => ['Accent', 'Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'i10'],
            'Volkswagen' => ['Golf', 'Passat', 'Polo', 'Tiguan', 'Jetta', 'Beetle'],
            'Chevrolet' => ['Spark', 'Aveo', 'Cruze', 'Malibu', 'Camaro', 'Tahoe'],
            'Mazda' => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-3', 'CX-5', 'MX-5'],
            'Subaru' => ['Impreza', 'Legacy', 'Outback', 'Forester', 'BRZ'],
            'Jeep' => ['Wrangler', 'Cherokee', 'Grand Cherokee', 'Compass', 'Renegade'],
            'Lexus' => ['IS', 'ES', 'GS', 'NX', 'RX', 'LX'],
            'Hyundai' => ['Accent', 'Elantra', 'Tucson', 'Santa Fe'],
            'Mitsubishi' => ['Lancer', 'Outlander', 'ASX', 'Pajero'],
            'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
            'Volvo' => ['S60', 'S90', 'XC40', 'XC60', 'XC90'],
            'Porsche' => ['911', 'Cayenne', 'Panamera', 'Macan'],
            'Range Rover' => ['Evoque', 'Velar', 'Discovery', 'Sport'],
            'Fiat' => ['500', 'Punto', 'Tipo', 'Panda'],
            'Renault' => ['Clio', 'Megane', 'Captur', 'Kangoo'],
            'Peugeot' => ['208', '308', '3008', '5008'],
            'Citroen' => ['C3', 'C4', 'C5', 'Aircross'],
            'Suzuki' => ['Swift', 'Baleno', 'Vitara', 'Jimny'],
            'Toyota (Luxury)' => ['Supra', 'Crown'],
        ];

        foreach ($data as $brandName => $models) {
            $brand = Brand::create(['name' => $brandName]);

            foreach ($models as $model) {
                CarModel::create([
                    'brand_id' => $brand->id,
                    'name' => $model,
                ]);
            }
        }
    }
}
