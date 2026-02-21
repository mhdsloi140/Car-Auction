<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Car extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'brand_id',
        'model_id',
        'year',
        'city',
        'mileage',
        'plate_number',
        'description',
        'specs',
        //  'report_pdf'
    ];
    public function getSpecsLabelAttribute()
    {
        return [
            'gcc' => 'خليجية',
            'non_gcc' => 'غير خليجية',
            'unknown' => 'لا أعلم',
        ][$this->specs] ?? null;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function auction()
    {
        return $this->hasOne(Auction::class);
    }
    public function registerMediaCollections(): void
    {
        $this ->addMediaCollection('cars'); // بدون singleFile()
        $this->addMediaCollection('car_reports');
    }


}
