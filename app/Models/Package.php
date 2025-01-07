<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'features',
        'price',
        'duration',
        'status',
    ];

    // Relationship with Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relationship with PackageImage
    public function images()
    {
        return $this->hasMany(PackageImage::class);
    }
}
 