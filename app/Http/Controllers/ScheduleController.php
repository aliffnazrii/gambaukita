<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class ScheduleController extends Controller
{
    // Display a listing of the schedules
    public function index()
    {


    $schedules = Schedule::all();

    return view('owner.schedule', compact('schedules'));
    }

    public function getEvents()
{
    $schedules = Schedule::all();

    return response()->json($schedules);
}

    // Show the form for creating a new schedule
    public function create()
    {
        $users = User::all();
        return view('schedules.create', compact('users'));
    }

    // Store a newly created schedule in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'title' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
        ]);
    
        // Check for overlap with bookings
        $bookingOverlapExists = Booking::where('user_id', $request->user_id)
            ->whereBetween('event_date', [$request->start, $request->end])
            ->exists();
    
        // Check for overlap with existing schedules
        $scheduleOverlapExists = Schedule::where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start', [$request->start, $request->end])
                      ->orWhereBetween('end', [$request->start, $request->end])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start', '<=', $request->end)
                                ->where('end', '>=', $request->start);
                      });
            })
            ->exists();
    
        // If overlaps exist in either bookings or schedules, return an error
        if ($bookingOverlapExists || $scheduleOverlapExists) {
            return redirect()->back()->withErrors(['overlap' => 'The schedule overlaps with an existing booking or schedule. Please choose a different time.']);
        }
    
        // Create the schedule if no overlap
        Schedule::create($validatedData);
    
        return redirect()->route('owner.schedule')->with('success', 'Schedule created successfully.');
    }
    

    // Display the specified schedule
    public function show($id)
    {
        $schedule = Schedule::with('user')->findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    // Show the form for editing the specified schedule
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $users = User::all();
        return view('schedules.edit', compact('schedule', 'users'));
    }

    // Update the specified schedule in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($validatedData);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    // Remove the specified schedule from the database
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }

// owner section

// public function ownerSchedule(){
//     $schedules  = Schedule::with('user')->where('user_id', AUTH::user()->id)->get();
// $bookings = Booking::get('event_date');
//     return view('owner.schedule', compact('schedules'));
// }

public function ownerSchedule()
{
    // Get authenticated user's schedules
    $schedules = Schedule::where('user_id', auth()->user()->id)
        ->get(['start', 'end', 'time', 'title']);

    // Get all bookings for the authenticated user
    $bookings = Booking::where('user_id', auth()->user()->id)
        ->get(['event_date', 'event_time', 'venue', 'remark']);

    // Normalize schedules
    $formattedSchedules = $schedules->map(function ($schedule) {
        return [
            'type' => 'Schedule',
            'date' => $schedule->start,
            'end_date' => $schedule->end,
            'time' => $schedule->time,
            'title' => $schedule->title,
        ];
    });

    // Normalize bookings
    $formattedBookings = $bookings->map(function ($booking) {
        return [
            'type' => 'Booking',
            'date' => $booking->event_date,
            'end_date' => null, // Bookings don't have an end date
            'time' => $booking->event_time,
            'title' => $booking->venue,
        ];
    });

    // Combine both normalized collections
    $allEvents = $formattedSchedules->concat($formattedBookings);

    // Pass data to the view
    return view('owner.schedule',compact('allEvents'));
}




}