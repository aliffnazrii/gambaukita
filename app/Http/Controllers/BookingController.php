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
        return view('client.booking', compact('packages','schedules'));
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


    // public function checkDate(Request $request)
    // {
    //     $request->validate([
    //         'checkdate_input' => 'required|date|after:today', // Ensures the date is valid and after today
    //     ]);

    //     $bookingDate = $request->input('checkdate_input');
    //     $isDateAvailable = $this->isDateAvailable($bookingDate);

    //     // Check if the date is available using the isDateAvailable method
    //     if ($isDateAvailable) {
    //         // If the date is available, store it in the session
    //         // session()->put('event_date', $bookingDate);

    //         // Redirect to Step 2
    //         return redirect()->route('bookings.step2')->with('msg', 'The selected date is available.');
    //         return redirect('/');
    //     } else {
    //         // If the date is unavailable, redirect back to Step 1 with an error
    //         return back()->withErrors(['checkdate_input' => 'The selected date is unavailable. Please choose a different date.']);
    //         // return back();
    //     }
    // }



    // Example function to check date availability (customize as needed)
    // private function isDateAvailable($bookingDate)
    // {
    //     // Check if the selected date exists in the Schedule table
    //     $schedule = Schedule::where('start', $bookingDate)->first();

    //     // Check if the selected date already has a booking
    //     $otherBookings = Booking::where('event_date', $bookingDate)->first();

    //     // If the date exists in either table, it is unavailable
    //     if ($schedule || $otherBookings) {
    //         return false; // Date is unavailable
    //     }

    //     // If no conflicts are found, the date is available
    //     return true;
    // }


    // public function step2()
    // {
    //     // Check if the event date is stored in the session
    //     if (!session()->has('event_date')) {
    //         return redirect()->route('bookings.create')->with('error', 'Please select a valid date first.');
    //     }

    //     // Retrieve the event date from the session
    //     $eventDate = session('event_date');

    //     // Pass the date to the view (if needed)

    //     $packages = Package::all();
    //     return redirect()->route('bookings.create',compact('eventDate','packages'));
    // }



    // Store a newly created booking in the database
    public function store(Request $request)
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
            'deposit_percentage' => 'required|numeric',

        ]);
        $packageId = $validatedData['package_id'];
        $price = Package::where('id', $packageId)->value('price');
        $validatedData['total_price'] =  $price;
        //    'total_price' => 'required|numeric',


        $booking = Booking::create($validatedData);
        $depositAmount = $price * ($validatedData['deposit_percentage'] / 100);

        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => 'INV-' . time() . '-' . $booking->id, // Generate a unique invoice number
            'invoice_date' => now(),
            'total_amount' => $depositAmount,
            'status' => 'unpaid',
        ]);

        return redirect()->route('booking.payment', ['booking_id' => $booking->id]);
        // return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }


    public function paymentSuccess($bookingId)
    {
        // Retrieve booking and related invoice
        $booking = Booking::findOrFail($bookingId);
        $invoice = Invoice::where('booking_id', $bookingId)->firstOrFail();

        // Update invoice status to "paid"
        $invoice->status = 'paid';
        $invoice->save();

        // Create a payment record for this transaction
        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'deposit',
            'amount' => $invoice->total_amount,
            'status' => 'completed',
            'transaction_id' => request('payment_intent'), // Optionally store the Stripe payment intent ID
            'payment_method' => 'fpx', // Or 'card' based on method used
        ]);

        // Update booking status to confirmed
        $booking->acceptance_status = 'confirmed';
        $booking->save();

        return view('payment.success', ['booking' => $booking]);
    }




    // Display the specified booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        return view('client.view-history', compact('booking'));
    }

    public function showInvoice($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        return view('client.invoice', compact('booking'));
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
