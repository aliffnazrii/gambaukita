<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Notifications\notifications;

class PaymentController extends Controller
{


    public function processBookingPayment($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $depositAmount = Invoice::where('booking_id', $booking->id)
            ->latest('created_at')
            ->value('total_amount');

        $depositAmount = $depositAmount * 100;

        // Initialize Stripe with your secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a Payment Intent for the deposit amount
        $paymentIntent = PaymentIntent::create([
            'amount' => $depositAmount, // Amount in cents
            'currency' => 'myr',
            'payment_method_types' => [
                'fpx',
                'card',
                'grabpay',
            ],
            'metadata' => [
                'booking_id' => $booking->id,
            ],
        ]);

        return view('payment.payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'bookingId' => $booking->id,
            'depositAmount' => $depositAmount,
        ]);
    }
}
