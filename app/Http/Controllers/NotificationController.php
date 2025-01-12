<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\notifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(User $user, array $data)
    {
        $user->notify(new notifications($data));

    }
}
