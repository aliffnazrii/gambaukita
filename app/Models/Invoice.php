<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'invoice_number',  // Unique identifier for the invoice
        'invoice_date',    // Date the invoice was issued
        'total_amount',    // Total amount for the invoice
        'status',          // e.g., "unpaid", "paid"
    ];

    // Relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
