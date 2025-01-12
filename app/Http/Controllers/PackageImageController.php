<?php

namespace App\Http\Controllers;

use App\Models\PackageImage;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\notifications;

class PackageImageController extends Controller
{
    // Display a listing of the package images
    public function index()
    {
        $images = PackageImage::with('package')->get();
        return view('package_images.index', compact('images'));
    }

    // Show the form for creating a new package image
    public function create()
    {
        $packages = Package::all();
        return view('package_images.create', compact('packages'));
    }

    // Store a newly created package image in the database
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'package_id' => 'required|exists:packages,id',
        ]);

        // Handle the image file upload
        if ($request->hasFile('image')) {
            // Store the image in the 'public' disk
            $image = $request->file('image');
            $imagePath = $image->store('package_images', 'public');  // Store the file in 'public/images'
            $imagePath = '/' . 'storage/' . $imagePath;

            // Save the image path to the database (you can use your model to save it)
            $packageImage = new PackageImage();
            $packageImage->package_id = $request->package_id;
            $packageImage->image_url = $imagePath;  // Store the relative file path
            $packageImage->save();

            return redirect()->back()->with('success', 'Image uploaded successfully!');
        }

        return redirect()->back()->with('failed', 'Image not uploaded');
    }


    // Display the specified package image
    public function show($id)
    {
        $image = PackageImage::with('package')->findOrFail($id);
        return view('package_images.show', compact('image'));
    }




    // Remove the specified package image from the database
    public function destroy($id)
    {
        // Retrieve the image record
        $image = PackageImage::findOrFail($id);

        // Get the package ID related to the image
        $packageId = $image->package_id;

        // Retrieve the package and eager load the 'images' relation (optional)
        $package = Package::with('images')->findOrFail($packageId);

        // Extract the image path (adjust this based on how you store images)
        $oldImagePath = str_replace('/' . 'storage/', '', $image->image_url);

        // Check if the image file exists in the public storage
        if (Storage::disk('public')->exists($oldImagePath) && $package->images->count() > 1) {
            // Delete the old image file
            Storage::disk('public')->delete($oldImagePath);

            // Delete the image record from the database
            $image->delete();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } else {
            // If the image file doesn't exist, return with a failure message
            return redirect()->back()->with('failed', 'Deletion failed. Cannot delete single image.');
        }
    }
}
