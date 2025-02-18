<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\notifications;
use App\Notifications\EmailNotifications;

use PDO;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Notification::route('mail', $user->email)
            ->notify(new EmailNotifications($user, 'user_registered', [$user->id]));

        #EMAIL NOTI
        $email = new UserController();
        $email->sendEmail($user, 'user_registered', [$user->id]);

        #NOTIFY OWNER
        $newuser = User::where('role', 'Owner')->get();

        if ($newuser) {
            // Define notification data
            $data = [
                'title' => 'GambauKita',
                'message' => 'New User Signed Up !',
                'url' => 'owner/view-clients', // Correct way to use the user's ID
            ];

            // Create the notification instance and send it

            foreach ($newuser as $owner) {
                $Notification = new UserController();
                $Notification->sendNotification($owner, $data); // Pass the user model and data
            }
        }
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $bookings = Booking::with('package')->where('user_id', $user->id)->get();
        return view('client.profile', compact('user', 'bookings'));
    }


    public function edit(User $user)
    {
        return view('client.profile', compact('user'));
    }

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

        if ($user->update($reqval)) {
            $email = new UserController();
            $email->sendEmail($user, 'update_account', [$user->id]);

            $notiId = Auth::user();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Information Update Succeed',
                'url' => '/users/' . $user->id,
            ];

            $Notification = new UserController();
            $Notification->sendNotification($notiId, $data);
        }

        $bookings = Booking::with('package')->where('user_id', $user->id)->get();
        return redirect()->back()
            ->with('success', 'User updated successfully.');
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

        if ($user->update($reqval)) {

            $notiId = Auth::user();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Information Update Succeed',
                'url' => '/users/' . $user->id,
            ];

            $Notification = new UserController();
            $Notification->sendNotification($notiId, $data);
        }

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

        if ($user->save()) {

            $notiId = Auth::user();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Password Updated',
                'url' => '/users/' . $user->id,
            ];

            $Notification = new UserController();
            $Notification->sendNotification($notiId, $data);
            $email = new NotificationController();
            $email->sendEmail($notiId, 'update_password', [
                'id' => $notiId->id,
            ]);
        }

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

        if ($user->save()) {


            $email = new UserController();
            $email->sendEmail($user, 'profile_picture_update', [$user->id]);

            $notiId = Auth::user();
            $data = [
                'title' => 'GambauKita',
                'message' => 'Profile Picture Updated',
                'url' => '/users/' . $user->id,
            ];

            $Notification = new UserController();
            $Notification->sendNotification($notiId, $data);
        }
        return redirect()->back();
    }



    //OWNER SECTION

    public function dashboard()
    {
        $user = AUTH::user();
        $clients = User::where('role', 'Client')->get();
        $packages = Package::all();
        $bookings = Booking::all();


        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyEarnings = Booking::with('payments')->whereHas('payments', function ($query) {
            $query->where('status', 'Completed');
        })
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_price');
        $totalEarnings = Booking::with('payments')->whereHas('payments', function ($query) {
            $query->where('status', 'Completed');
        })
            ->sum('total_price');


        return view('owner.dashboard', compact('user', 'clients', 'bookings', 'packages', 'monthlyEarnings', 'totalEarnings'));
    }

    public function ownerProfile()
    {
        $user = AUTH::user();
        return view('owner.owner-profile', compact('user'));
    }

    public function viewClients()
    {
        $users = User::where('role', 'Client')->get();
        return view('owner.clients', compact('users'));
    }

    public function sendNotification(User $user, array $data)
    {
        $user->notify(new notifications($data));
    }


    public function sendEmail(User $user, $activity, array $data)
    {
        $user->notify(new EmailNotifications($user, $activity, $data));
    }
}
