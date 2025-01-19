<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\NotificationController;

class ScheduleController extends Controller
{

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'title' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
        ]);

        $bookingOverlapExists = Booking::where('user_id', $request->user_id)
            ->whereBetween('event_date', [$request->start, $request->end])
            ->exists();

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

        if ($bookingOverlapExists || $scheduleOverlapExists) {
            return redirect()->back()->withErrors(['overlap' => 'The schedule overlaps with an existing booking or schedule. Please choose a different time.']);
        }


        $schedule =  Schedule::create($validatedData);

        if ($schedule) {

            $user =  Auth::user();

            #EMAIL NOTI
            $email = new NotificationController();
            $email->sendEmail($user, 'create_schedule', [$schedule->id]);

            #NOTIFY OWNER
            $newuser = User::where('role', 'Owner')->get();

            $data = [
                'title' => 'GambauKita',
                'message' => 'New Schedule Added.',
                'url' => route('owner.schedule'), // Correct way to use the user's ID
            ];

            foreach ($newuser as $owner) {
                $Notification = new NotificationController();
                $Notification->sendNotification($owner, $data); // Pass the user model and data
            }
        }

        return redirect()->route('owner.schedule')->with('success', 'Schedule created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::findOrFail($id);
       

        if ($schedule->update($validatedData)) {

            $newuser = User::where('role', 'Owner')->get();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Schedule ' . $schedule->title . ' Updated.',
                'url' => 'owner/schedule',
            ];
            foreach ($newuser as $owner) {
                $Notification = new NotificationController();
                $Notification->sendNotification($owner, $data);
            }
        }
        return redirect()->route('owner.schedule')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        if ($schedule->delete()) {

            $user =  Auth::user();
            $newuser = User::where('role', 'Owner')->get();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Schedule ' . $schedule->title . ' deleted successfully.',
                'url' => 'owner/schedule', // Correct way to use the user's ID
            ];

            foreach ($newuser as $owner) {
                $Notification = new NotificationController();
                $Notification->sendNotification($owner, $data); // Pass the user model and data
            }
        }

        return redirect()->route('owner.schedule')->with('success', 'Schedule deleted successfully.');
    }

    // owner section
    public function ownerSchedule()
    {
        $schedules = Schedule::all();
        $bookings = Booking::with('user')->get();

        // Pass data to the view
        return view('owner.schedule', compact('schedules', 'bookings'));
    }
}
