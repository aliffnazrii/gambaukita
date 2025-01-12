<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\ClientMiddleware;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\notifications;

class PortfolioController extends Controller
{

    public function __construct(){
        $this->middleware(CheckUserRole::class)->only(['ownerPortfolio','destroy','create','update','edit','store']);
        // $this->middleware(ClientMiddleware::class);
    }
    // Display a listing of the portfolios
    public function index()
    {
        $portfolios = Portfolio::with('user')->get();
        return view('client.portfolio', compact('portfolios'));
    }

    // Show the form for creating a new portfolio
    public function create()
    {
        $users = User::all();
        return view('portfolios.create', compact('users'));
    }

    // Store a newly created portfolio in the database (in use)

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);



        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate image before storing
                if ($image->isValid()) {
                    // Store the image and get its storage path
                    $path = $image->store('portfolios', 'public');

                    Portfolio::create([
                        'package_id' => $request->id,
                        'user_id' => $request->user_id,
                        'title' => $request->title,
                        'description' => $request->description,
                        'image_url' => Storage::url($path), // Storing the public URL
                    ]);
                } else {
                    return redirect()->back()->withErrors(['images' => 'One or more images failed to upload.']);
                }
            }
        } else {
            Portfolio::create($validatedData);
        }
        return redirect()->route('owner.portfolio')->with('success', 'Portfolio created successfully.');
    }

    // Display the specified portfolio
    public function show($id)
    {
        $portfolio = Portfolio::with('user')->findOrFail($id);
        return view('portfolios.show', compact('portfolio'));
    }

    // Show the form for editing the specified portfolio
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $users = User::all();
        return view('portfolios.edit', compact('portfolio', 'users'));
    }

    // Update the specified portfolio in the database (in use)
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $portfolio = Portfolio::findOrFail($id);
        $portfolio->update($validatedData);

        return redirect()->route('owner.portfolio')->with('success', 'Portfolio updated successfully.');
    }

    // Remove the specified portfolio from the database (in use)

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();

        return redirect()->back()->with('success', 'Portfolio deleted successfully.');
    }



    // owner section

    public function ownerPortfolio()//(in use)

    {
        $portfolios = Portfolio::all();
        return view('owner.all-portfolio', compact('portfolios'));
    }
}
