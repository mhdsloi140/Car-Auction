<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_id',
        'seller_id',
        'starting_price',
        'current_price',
        'buy_now_price',

        'start_at',
        'end_at',
        'duration_hours',
        'status',
        'approved_by',
        'winner_id',
        'final_price',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'buy_now_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        // 'min_increment' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'pending',
        // 'min_increment' => 100,
        'duration_hours' => 24,
    ];

    // العلاقات فقط
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

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // دوال مساعدة بسيطة جداً (اختيارية)
    public function getCurrentPriceAttribute($value)
    {
        return $value ?? $this->starting_price;
    }
}
