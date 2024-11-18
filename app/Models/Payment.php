<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
       'booking_id',
        'type',            // e.g., "deposit" or "balance"
        'amount',          // Amount for this specific payment
        'status',          // e.g., "pending", "completed"
        'transaction_id',  // Stripe transaction ID or payment intent ID
        'payment_method',  // e.g., "card", "fpx"
    ];

    // Relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
