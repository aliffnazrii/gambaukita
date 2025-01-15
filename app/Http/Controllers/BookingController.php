<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Controllers\NotificationController;

class BookingController extends Controller
{


    public function index()
    {
        $bookings = Booking::with(['user', 'package'])->where('user_id', Auth::user()->id)->get();
        return view('client.history', compact('bookings'));
    }

    public function create()
    {
        $packages = Package::all();
        $schedules = Schedule::all();
        $bookings = Booking::all();
        return view('client.booking', compact('packages', 'schedules', 'bookings'));
    }

    public function checkdate(Request $req)
    {

        if (Auth::user()) {
            $check = Auth::user()->id;
            $checkData = User::findOrFail($check);

            if ($checkData->phone == '' && $checkData->address == '' && $checkData->postcode == '') {
                return back()->with('failed', 'Please complete your profile before proceeding with this booking.');
            }
        } else {
            return back()->with('failed', 'Login Required');
        }


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

    #OVERLAP SCHEDULE CHECK
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

    public function store(Request $request)
    {

        if (Auth::user()) {
            $check = Auth::user()->id;
            $checkData = User::findOrFail($check);

            if ($checkData->phone == '' && $checkData->address == '' && $checkData->postcode == '') {
                return back()->with('failed', 'Please complete your profile before proceeding with this booking.');
            }
        } else {
            return back()->with('failed', 'Login Required');
        }

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
                        'payment_method' => request('payment_method_types'), // Or 'card' based on method used
                    ]);

                    // Update booking status to confirmed
                    $booking->acceptance_status = 'Accepted';
                    $booking->progress_status = 'Booked';
                    $booking->save();

                    if ($booking) {

                        $user =  Auth::user();

                        if ($user) {

                            $data = [
                                'title' => 'GambauKita',
                                'message' => 'A booking at' . \Carbon\Carbon::parse($booking->event_date)->format('d M, Y') . ' has been made.',
                                'url' => 'bookings.index',
                            ];

                            #EMAIL NOTI
                            $email = new NotificationController();
                            $email->sendEmail($user, 'create_booking_client', [$booking]);
                        }

                        #NOTIFY OWNER
                        $newuser = User::where('role', 'Owner')->get();

                        // \Carbon\Carbon::parse($booking->event_date)->format('d M, Y')

                        if ($newuser) {

                            $data = [
                                'title' => 'GambauKita',
                                'message' => 'A booking at' . \Carbon\Carbon::parse($booking->event_date)->format('d M, Y') . ' has been made.',
                                'url' => 'owner.booking',
                            ];

                            foreach ($newuser as $owner) {
                                $Notification = new NotificationController();
                                $Notification->sendNotification($owner, $data);
                                $email->sendEmail($user, 'create_booking_owner', [$booking]);
                            }
                        }
                    }

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

            // PAY BALANCE
            foreach ($invoices as $invoice) {
                if ($invoice->status == 'Unpaid') {
                    $invoice->status = 'Paid';
                    $invoice->save();

                    $currentPayment = Payment::create([
                        'booking_id' => $bookingId,
                        'type' => 'Balance',
                        'amount' => $invoice->total_amount,
                        'status' => 'Completed',
                        'transaction_id' => request('payment_intent'),
                        'payment_method' => request('payment_method_types')
                    ]);

                    $booking->acceptance_status = 'accepted';


                    #NOTIFICATION
                    if ($booking->save()) {

                        $user =  Auth::user();

                        if ($user) {

                            #PUSH NOTI
                            $data = [
                                'title' => 'GambauKita',
                                'message' => 'Balance payment for booking at ' . \Carbon\Carbon::parse($booking->event_date)->format('d M, Y') . ' has been made.',
                                'url' => route('bookings.show', $booking->id),
                            ];

                            #EMAIL NOTI
                            $email = new NotificationController();
                            $email->sendEmail($user, 'pay_balance', [$booking]);
                        }

                        #NOTIFY OWNER
                        $newuser = User::where('role', 'Owner')->get();

                        // \Carbon\Carbon::parse($booking->event_date)->format('d M, Y')

                        #PUSH NOTI
                        if ($newuser) {

                            $data = [
                                'title' => 'GambauKita',
                                'message' => 'A booking at' . \Carbon\Carbon::parse($booking->event_date)->format('d M, Y') . ' has been fully paid.',
                                'url' => route('bookings.edit', $booking->id),
                            ];

                            #EMAIL NOTI

                            foreach ($newuser as $owner) {
                                $Notification = new NotificationController();
                                $Notification->sendNotification($owner, $data);
                                $email->sendEmail($user, 'create_booking_owner', [$booking]);
                            }
                        }
                    }

                    $booking = Booking::with(['user', 'payments'])->findOrFail($bookingId);
                    return view('payment.success', ['booking' => $booking, 'payments' => $currentPayment]);
                }
            }
        }

        return redirect()->route('bookings.show', compact('booking'))->with('failed', 'Payment Failed');
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        return view('client.view-history', compact('booking'));
    }

    public function showInvoice($id)
    {


        $invoice = Invoice::findOrFail($id);

        $booking = Booking::findOrFail($invoice->booking_id);

        return view('client.invoice', compact('invoice', 'booking'));
    }

    public function showReceipt($id)
    {


        $payments_id = Payment::findOrFail($id);

        $booking = Booking::findOrFail($payments_id->booking_id);

        $payment = Payment::where('booking_id', $booking->id)->get();

        $amount = 0;
        $details = [];


        foreach ($payment as $pay) {
            $amount = $amount + $pay->amount;
            $transaction_id = $pay->transaction_id;
            $created_at = $pay->created_at;
            $status = $pay->status;
        }
        return view('payment.receipt', compact('booking', 'amount', 'created_at', 'details', 'transaction_id', 'status'));



        $details[] = [
            'amount' => $amount + $pay->amount,
            'transaction_id' => $pay->transaction_id,
            'created_at' => $pay->created_at,
            'status' => $pay->status,
        ];

        return view('payment.receipt', compact('details', 'booking'));
    }


    public function edit($id)
    {
        $booking = Booking::with(['user', 'package', 'payments', 'invoices'])->findOrFail($id);
        return view('owner.detailedBooking', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'progress_status' => 'required|in:Pending,Booked,Waiting,Completed,Cancelled', // Only allow specific statuses
            'link' => $request->progress_status === 'Completed' ? 'required|url' : 'nullable', // Conditionally required for 'Completed'
        ]);
        $booking = Booking::findOrFail($id);


        #NOTIFICATION
        if ($booking->update($validatedData)) {

            $user =  Auth::user();

            if ($user) {

                #PUSH NOTI
                $data = [
                    'title' => 'GambauKita',
                    'message' => 'Your booking status has been updated.',
                    'url' => route('bookings.show', $booking->id),
                ];

                #EMAIL NOTI
                $email = new NotificationController();
                $email->sendEmail($user, 'update_booking', [$booking]);
            }

            #NOTIFY OWNER
            $newuser = User::where('role', 'Owner')->get();

            // \Carbon\Carbon::parse($booking->event_date)->format('d M, Y')

            #PUSH NOTI
            if ($newuser) {

                $data = [
                    'title' => 'GambauKita',
                    'message' => 'A booking has been fully paid.',
                    'url' => route('bookings.edit', $booking->id),
                ];

                #EMAIL NOTI

                foreach ($newuser as $owner) {
                    $Notification = new NotificationController();
                    $Notification->sendNotification($owner, $data);
                    // $email->sendEmail($user, 'create_booking_owner', [$booking]);
                }
            }
        }

        return redirect()->back()->with('success', 'Booking updated successfully.');
    }


    // OWNER FUNCTIONS

    public function ownerindex()
    {
        $bookings = Booking::with(['user', 'package', 'payments', 'invoices'])->get();
        return view('owner.all-booking', compact('bookings'));
    }
}
