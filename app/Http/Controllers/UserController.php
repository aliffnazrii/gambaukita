<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('client.profile', compact('user'));
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

    public function updateProfilePicture(Request $request, $id)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = User::findOrFail($id); // Find the user by ID
        $file = $request->file('profile_picture');
        $path = $file->store('profile_pictures', 'public');
        $path = '/storage'.'/' . $path;
        // Update the user's profile picture path in the database
        $user->picture = $path;
        $user->save();

        return redirect()->back();
    }


    // Remove the specified user from the database
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    //OWNER SECTION

    public function dashboard()
    {
        $user = AUTH::user();
        return view('owner.dashboard', compact('user'));
    }

    public function ownerProfile()
    {
        $user = AUTH::user();
        return view('owner.owner-profile', compact('user'));
    }
}
