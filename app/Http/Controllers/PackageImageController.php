<?php

namespace App\Http\Controllers;

use App\Models\PackageImage;
use App\Models\Package;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'image_url' => 'required|url',
        ]);

        PackageImage::create($validatedData);

        return redirect()->route('package_images.index')->with('success', 'Package image created successfully.');
    }

    // Display the specified package image
    public function show($id)
    {
        $image = PackageImage::with('package')->findOrFail($id);
        return view('package_images.show', compact('image'));
    }

    // Show the form for editing the specified package image
    public function edit($id)
    {
        $image = PackageImage::findOrFail($id);
        $packages = Package::all();
        return view('package_images.edit', compact('image', 'packages'));
    }

    // Update the specified package image in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'image_url' => 'required|url',
        ]);

        $image = PackageImage::findOrFail($id);
        $image->update($validatedData);

        return redirect()->route('package_images.index')->with('success', 'Package image updated successfully.');
    }

    // Remove the specified package image from the database
    public function destroy($id)
    {
        $image = PackageImage::findOrFail($id);
        $image->delete();

        return redirect()->route('package_images.index')->with('success', 'Package image deleted successfully.');
    }
}
