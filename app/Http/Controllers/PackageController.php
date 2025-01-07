<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckUserRole;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PackageImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class PackageController extends Controller
{

    public function __construct(){
        $this->middleware(CheckUserRole::class)->only(['store','create','update','edit','destroy']);
    }
    // Display a listing of the packages
    public function index()
    {
        $packages = Package::with(['images' => function ($query) {
            $query->limit(1);  // Get only the first image
        }])->get();
        return view('client.catalogue', compact('packages'));
    }

    // Show the form for creating a new package
    public function create()
    {
        return view('packages.create');
    }

    // Store a newly created package in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the package entry
        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);

        // Check if images are uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate image before storing
                if ($image->isValid()) {
                    // Store the image and get its storage path
                    $path = $image->store('package_images', 'public');

                    // Create an entry in the package_images table
                    PackageImage::create([
                        'package_id' => $package->id,
                        'image_url' => Storage::url($path), // Storing the public URL
                    ]);
                } else {
                    return redirect()->back()->withErrors(['images' => 'One or more images failed to upload.']);
                }
            }
        }

        // Return a success message
        return redirect()->route('owner.package')->with('success', 'Package created successfully with images.');
    }


    public function uploadPackageImage(Request $request)
    {
        $images = $request->file('images');  // Assuming you're sending an array of images

        $urls = [];
        foreach ($images as $image) {
            // Store the image in the 'public/package_images' folder
            $path = $image->store('package_images', 'public');
            $urls[] = asset('storage/' . $path);  // Generate public URL for the image
        }

        return response()->json([
            'status' => 'success',
            'image_urls' => $urls
        ]);
    }
    // Display the specified package
    public function show($id)
    {
        $package = Package::with('images')->findOrFail($id);
        return view('owner.open-package', compact('package'));
    }

    // Show the form for editing the specified package
    public function edit($id)
    {
        $package = Package::with('images')->findOrFail($id);
        return view('owner.open-package', compact('package'));
    }

    public function view($id)
    {
        $package = Package::with('images')->findOrFail($id);
        return view('owner.open-package', compact('package'));
    }


    // Update the specified package in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'status' => 'required|string'
        ]);

        $package = Package::findOrFail($id);
        $package->update($validatedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate image before storing
                if ($image->isValid()) {
                    // Store the image and get its storage path
                    $path = $image->store('package_images', 'public');

                    // Create an entry in the package_images table
                    $update = PackageImage::findOrFail($id);
                    $update->update( ['image_url' => Storage::url($path)]);
                   
                } else {
                    return redirect()->back()->withErrors(['images' => 'One or more images failed to upload.']);
                }
            }
        }

        return redirect()->back()->with('success', 'Package updated successfully.');
    }

    // // Remove the specified package from the database
    // public function destroy($id)
    // {
    //     $package = Package::findOrFail($id);

    //     $status = 'inactive';
    //     // Set the 'status' column to 'inactive'
    //     $package->update(['status' =>  $status]);
    //     return redirect()->route('owner.package')->with('success', 'Package deleted successfully.');
    // }




    // OWNER SECTION

    public function ownerPackage()
    {
        $packages = Package::all();
        return view('owner.all-package', compact('packages'));
    }

    public function ownerPackageView($id)
    {
        // $package = Package::with('images')->findOrFail($id);

        $package = Package::where('id', $id)->with('images')->first();
        return view('owner.open-package', compact('package'));
    }
    
    
    public function viewPackage($id){
        $package = Package::with('images')->findOrFail($id);
    return view('client.viewPackage',compact('package'));
    }
}