<?php

namespace App\Http\Controllers;
use App\Notifications\notifications;

use Illuminate\Http\Request;
use App\Models\Package;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $packs = Package::with('images')->where('status', 'Active')->get();
        return view('client.home', compact('packs'));
    }

}
