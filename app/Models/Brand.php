<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name'];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brands')->singleFile();
    }

       public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

}
