<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'end' => 'required|date',
            'title' => 'required|string|max:255',
        ]);

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

public function ownerSchedule(){
    $schedules  = Schedule::with('user')->where('user_id', AUTH::user()->id)->get();
    return view('owner.schedule', compact('schedules'));
}


}