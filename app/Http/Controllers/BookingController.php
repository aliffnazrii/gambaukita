<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ClientMiddleware;

class BookingController extends Controller
{


    // Display a listing of the bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'package'])->where('user_id', Auth::user()->id)->get();
        return view('client.history', compact('bookings'));
    }

    // Show the form for creating a new booking
    public function create()
    {
        $packages = Package::all();
        $schedules = Schedule::all();
        $bookings = Booking::all();
        return view('client.booking', compact('packages', 'schedules', 'bookings'));
    }

    public function checkdate(Request $req)
    {
        $validated = $req->validate([
            'checkdate_input' => 'required|date|after:today', // Check for a valid date and future date
        ]);

        $bookingDate = $req->input('checkdate_input');

        // Check if the selected date exists in the Offday table
        $Schedule = Schedule::where('start', $bookingDate)->first();
        $otherBookings = Booking::where('event_date', $bookingDate)->first();

        if ($Schedule || $otherBookings) {
            // If the date is found in the Offday table, return an error response
            return back()->withErrors(['checkdate_input' => 'The selected date is unavailable. Please choose a different date.']);
        } else {
            session()->put('bookingDate', $bookingDate);
            return back()->with('msg', 'The particular date is available');
        }
    }

    public function Datecheck($date)
    {
        $bookingDate = $date;

        // Check if the selected date exists in the Offday table
        $Schedule = Schedule::where('start', $bookingDate)->first();
        $otherBookings = Booking::where('event_date', $bookingDate)->first();

        if ($Schedule || $otherBookings) {
            // If the date is found in the Offday table, return an error response
            return false;
        } else {

            return true;
        }
    }



    // Store a newly created booking in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'venue' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'event_time' => 'required|date_format:H:i',
            'remark' => 'nullable|string|max:255',
            'acceptance_status' => 'required|string|max:50',
            'progress_status' => 'required|string|max:50',
            'deposit_percentage' => 'required|numeric',

        ]);
        $packageId = $validatedData['package_id'];
        $price = Package::where('id', $packageId)->value('price');
        $validatedData['total_price'] = $price;
        //    'total_price' => 'required|numeric',

        $checkDate = $this->Datecheck($validatedData['event_date']);


        if ($checkDate) {


            $booking = Booking::create($validatedData);
            $depositAmount = $price * ($validatedData['deposit_percentage'] / 100);

            $invoice = Invoice::create([
                'booking_id' => $booking->id,
                'invoice_number' => 'INV-' . time() . '-' . $booking->id, // Generate a unique invoice number
                'invoice_date' => now(),
                'total_amount' => $depositAmount,
                'status' => 'Unpaid',
            ]);

            return redirect()->route('booking.payment', ['booking_id' => $booking->id]);
            // return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
        } else {
            return redirect()->back()->withErrors(['checkdate_input' => 'The selected date is unavailable or overlap. Please choose a different date.']);
        }

        return redirect()->back()->withErrors($checkDate)->withInput();
    }


    public function paymentSuccess($bookingId)
    {
        // Retrieve booking and related invoices
        $booking = Booking::findOrFail($bookingId);
        $invoices = Invoice::where('booking_id', $bookingId)->get();

        // Single invoice logic
        if (count($invoices) == 1) {
            foreach ($invoices as $invoice) {
                if ($invoice->status == 'Unpaid') {
                    $invoice->status = 'Paid';
                    $invoice->save();

                    // Create a payment record for this transaction
                    $payments = Payment::create([
                        'booking_id' => $booking->id,
                        'type' => 'deposit',
                        'amount' => $invoice->total_amount,
                        'status' => 'Completed',
                        'transaction_id' => request('payment_intent'), // Optionally store the Stripe payment intent ID
                        'payment_method' => 'fpx', // Or 'card' based on method used
                    ]);

                    // Update booking status to confirmed
                    $booking->acceptance_status = 'accepted';
                    $booking->save();

                    // Calculate and create balance payment invoice
                    $balanceAmount = $booking->total_price - ($booking->total_price * ($booking->deposit_percentage / 100));
                    $balancePayment = Invoice::create([
                        'booking_id' => $booking->id,
                        'invoice_number' => 'INV-' . time() . '-' . $booking->id, // Generate a unique invoice number
                        'invoice_date' => now(),
                        'total_amount' => $balanceAmount,
                        'status' => 'Unpaid',
                    ]);

                    $booking = Booking::with(['user', 'payments'])->findOrFail($bookingId);
                    return view('payment.success', compact('booking', 'balancePayment', 'payments'));
                }
            }
        } else {

            // Multiple invoice logic
            foreach ($invoices as $invoice) {
                if ($invoice->status == 'Unpaid') {
                    $invoice->status = 'Paid';
                    $invoice->save();

                    $currentPayment = Payment::create([
                        'booking_id' => $bookingId,
                        'type' => 'Balance',
                        'amount' => $invoice->total_amount,
                        'status' => 'Completed',
                        'transaction_id' => request('payment_intent'), // Optionally store the Stripe payment intent ID
                        'payment_method' => 'fpx', // Or 'card' based on method used
                    ]);

                    // Update booking status
                    $booking->acceptance_status = 'accepted';
                    $booking->progress_status = 'Waiting';
                    $booking->save();

                    $booking = Booking::with(['user', 'payments'])->findOrFail($bookingId);
                    return view('payment.success', ['booking' => $booking, 'payments' => $currentPayment]);
                }
            }
        }

        // Default failure response
        return redirect()->route('bookings.show', compact('booking'))->with('failed', 'Payment Failed');
    }





    // Display the specified booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        return view('client.view-history', compact('booking'));
    }

    public function showInvoice($id)
    {
        // $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        $invoice = Invoice::findOrFail($id);

        $booking = Booking::findOrFail($invoice->booking_id);

        return view('client.invoice', compact('invoice', 'booking'));
    }

    // Show the form for editing the specified booking
    public function edit($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        // $booking = Booking::findOrFail($id);

        return view('owner.detailedBooking', compact('booking'));
    }

    // Update the specified booking in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'venue' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'remark' => 'nullable|string|max:255',
            'acceptance_status' => 'required|string|max:50',
            'progress_status' => 'required|string|max:50',
            'booking_status' => 'required|string|max:50',
            'total_price' => 'required|numeric',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($validatedData);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    // Remove the specified booking from the database
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }


    // OWNER FUNCTIONS

    public function ownerindex()
    {
        $bookings = Booking::with(['user', 'package', 'payments', 'invoices'])->get();
        return view('owner.all-booking', compact('bookings'));
    }
}
