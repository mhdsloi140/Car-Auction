<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\Car;

class CarDetails extends Component
{
    public $car;

    public function mount($car)
    {
        $this->car = $car->load([
            'brand',
            'model',
            'media',
            'auction.bids.user'
        ]); 
        
    }


    public function render()
    {
        return view('livewire.seller.car-details');
    }
}
