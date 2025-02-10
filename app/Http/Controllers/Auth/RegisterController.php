<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);



        if ($user) {

            $data = [
                'title' => 'GambauKita',
                'message' => 'Thank you for signing up for GambauKita',
                'url' => route('users.show', $user->id),
            ];

            $Notification = new UserController();
            $Notification->sendNotification($user, $data); // Pass the user model and data

            #EMAIL NOTI
            $email = new NotificationController();
            $email->sendEmail($user, 'user_registered', [
                'id' => $user->id,
            ]);
        }

        $owner = User::where('role', 'Owner')->get();

        if ($owner) {
            // Define notification data
            $data = [
                'title' => 'GambauKita',
                'message' => 'New User Signed Up !',
                'url' => route('owner.viewClients'), // Correct way to use the user's ID
            ];

            // Create the notification instance and send it

            foreach ($owner as $owners) {
                $Notification = new UserController();
                $Notification->sendNotification($owners, $data); // Pass the user model and data
            }
        }

        return $user;
    }
}
