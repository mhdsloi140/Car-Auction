<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'car_id',
        'seller_id',
        'starting_price',
        'buy_now_price',
        'start_at',
        'end_at',
        'status',
        'approved_by',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}

