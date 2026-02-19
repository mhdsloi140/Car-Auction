<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Car;

class CarDetails extends Component
{
    public $car; // ❌ لا تضع type هنا

    public function mount($car)
    {
        $this->car = Car::with([
            'brand',
            'model',
            'media',
            'auction.bids.user'
        ])->findOrFail($car);
    }

    public function render()
    {
        return view('livewire.admin.car-details');
    }
}
