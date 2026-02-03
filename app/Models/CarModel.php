<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
       protected $fillable = [
        'brand_id', // الماركة التي ينتمي لها الموديل
        'name',     // اسم الموديل
    ];


        public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
