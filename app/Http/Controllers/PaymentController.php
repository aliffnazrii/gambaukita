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
        // $depositAmount = $booking->invoices->first()->deposit_amount;
        $depositAmount = Invoice::where('booking_id', $booking->id)
            ->latest('created_at') // Sort by the `created_at` column in descending order
            ->value('total_amount');



        $depositAmount = $depositAmount * 100;

        // Initialize Stripe with your secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a Payment Intent for the deposit amount
        $paymentIntent = PaymentIntent::create([
            'amount' => $depositAmount, // Amount in cents
            'currency' => 'myr',
            'payment_method_types' => ['fpx', 'card'],
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