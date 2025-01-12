<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'venue',
        'event_date',
        'event_time',
        'remark',
        'acceptance_status',
        'progress_status',
        'deposit_percentage',
        'total_price',
        'link',
    ];

    // Relationship with User 
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relationship with Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
