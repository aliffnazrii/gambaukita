<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Display a listing of users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified user
    public function show(User $user)
    {
        $bookings = Booking::with('package')->get();
        return view('client.profile', compact('user', 'bookings'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('client.profile', compact('user'));
    }

    // Update the specified user in the database
    public function update(Request $request, User $user)
    {
        $reqval = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'address' => 'nullable|string|max:500',
            'postcode' => 'nullable|string|regex:/^[0-9]{5}$/',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
        ]);

        $user->update($reqval);

        return view('client.profile', compact('user'))->with('success', 'User updated successfully.');
    }


    public function updateOwner(Request $request, User $user)
    {
        $reqval = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'address' => 'nullable|string|max:500',
            'postcode' => 'nullable|string|regex:/^[0-9]{5}$/',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
        ]);

        $user->update($reqval);

        return redirect()->route('owner.profile', compact('user'))->with('success', 'User updated successfully.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // password_confirmation will auto match with the input field 'password_confirmation'
        ]);

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['The provided password does not match our records.'],
            ]);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('owner.profile')->with('success', 'Password updated successfully.');
    }

    public function updateProfilePicture(Request $request, $id)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);


        $user = User::findOrFail($id);
        if ($user->picture) {
            // Remove the '/storage' prefix from the stored path
            $oldImagePath = str_replace('/storage/', '', $user->picture);

            // Check if the file exists before trying to delete it
            if (Storage::disk('public')->exists($oldImagePath)) {
                // Delete the old image file
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        // Get the new file from the request
        $file = $request->file('profile_picture');
        // Store the new profile picture and get the path
        $path = $file->store('profile_pictures', 'public');
        // Store the correct path for the database
        $path = '/storage' . '/' . $path;

        // Update the user's profile picture path in the database
        $user->picture = $path;
        $user->save();
        return redirect()->back();
    }



    //OWNER SECTION

    public function dashboard()
    {
        $user = AUTH::user();
        $clients = User::where('role', 'Client')->get();
        $packages = Package::all();
        $bookings = Booking::all();


        $startOfMonth = Carbon::now()->startOfMonth();  // Start of the current month
        $endOfMonth = Carbon::now()->endOfMonth();      // End of the current month

        $monthlyEarnings = Booking::where('progress_status', 'Completed')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_price');
        $totalEarnings = Booking::where('progress_status', 'Completed')
            ->sum('total_price');


        return view('owner.dashboard', compact('user', 'clients', 'bookings', 'packages', 'monthlyEarnings', 'totalEarnings'));
    }

    public function ownerProfile()
    {
        $user = AUTH::user();
        return view('owner.owner-profile', compact('user'));
    }
}
