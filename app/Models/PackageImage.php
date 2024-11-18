<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageImage extends Model
{
    use HasFactory;

    protected $table = 'package_images';

    protected $fillable = [
        'package_id',
        'image_url',
    ];

    // Relationship with Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
