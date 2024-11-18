<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Display a listing of the invoices
    public function index()
    {
        $invoices = Invoice::with('booking')->get();
        return view('invoices.index', compact('invoices'));
    }

    // Show the form for creating a new invoice
    public function create()
    {
        $bookings = Booking::all();
        return view('invoices.create', compact('bookings'));
    }

    // Store a newly created invoice in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'invoice_number' => 'required|integer|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:50',
        ]);

        Invoice::create($validatedData);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    // Display the specified invoice
    public function show($id)
    {
        $invoice = Invoice::with('booking')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    // Show the form for editing the specified invoice
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $bookings = Booking::all();
        return view('invoices.edit', compact('invoice', 'bookings'));
    }

    // Update the specified invoice in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'invoice_number' => 'required|integer|unique:invoices,invoice_number,' . $id,
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:50',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($validatedData);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    // Remove the specified invoice from the database
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
