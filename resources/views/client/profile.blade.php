@extends('layout.client')

@section('title', 'Profile')

@section('content')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .edit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s;
            cursor: pointer;
        }

        .profile-pic-container:hover .edit-overlay {
            opacity: 1;
        }


        .cropper-container {
            position: relative;
            background-size: cover;
            /* Cover the entire container */
            background-position: center;
            /* Center the background image */
            width: 100%;
            /* Full width */
            height: 70%;
            /* Set a fixed height for the cropper container */
            display: flex;
            /* Use flexbox to center the image */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            overflow: hidden;
            /* Hide overflow if the image exceeds the container */
        }
    </style>
@endsection

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card">
    <div class="card-body border">
        <h1 class="text-center m-5">Profile</h1>
        <div class="row">

            <!-- Profile Information Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body border text-center">

                        <!-- Profile Picture -->
                        <div class="profile-pic-container mx-auto">
                            @if ($user->picture == '')
                                <img src="https://via.placeholder.com/150" alt="Profile Picture"
                                    class="profile-pic img-fluid">
                            @else
                                <img src="{{ asset($user->picture) }}" alt="Profile Picture"
                                    class="profile-pic img-fluid">
                            @endif

                            <div class="edit-overlay" id="cameraIcon">
                                <i class="mdi mdi-camera"></i>
                            </div>
                            {{-- <input type="file" class="d-none" id="profilePictureInput" name="profile_picture"
                                    required> --}}
                            <input type="file" class="d-none" id="profilePictureInput" name="profile_picture"
                                accept="image/*">

                        </div>

                        <form id="hiddenProfileForm" method="POST" action="/users/update-picture/{{ $user->id }}"
                            enctype="multipart/form-data" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="file" class="d-none" id="hiddenProfilePictureInput" name="profile_picture">
                        </form>

                        <!-- Crop Image Modal -->
                        <div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog"
                            aria-labelledby="cropImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cropImageModalLabel">Crop Profile Picture</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="cropper-container m-auto">
                                            <img id="imageToCrop" style="max-width: 100%; display: block;">
                                        </div>
                                        {{-- <img id="imageToCrop" style="max-width: 100%; display: block;"> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="cropAndSave" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Include Cropper.js -->
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"
                            rel="stylesheet">
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('cameraIcon').addEventListener('click', function() {
                                    document.getElementById('profilePictureInput').click();
                                });

                                let cropper;
                                document.getElementById('profilePictureInput').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const image = document.getElementById('imageToCrop');
                                            image.src = e.target.result;
                                            $('#cropImageModal').modal('show');

                                            if (cropper) {
                                                cropper.destroy();
                                            }
                                            cropper = new Cropper(image, {
                                                aspectRatio: 1,
                                                viewMode: 1,
                                                autoCropArea: 3,
                                                // Optional: Set the initial crop box size
                                                width: 400, // Adjust this width as desired
                                                height: 300 // Adjust this height as desired
                                            });
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });

                                document.getElementById('cropAndSave').addEventListener('click', function() {
                                    if (cropper) {
                                        const canvas = cropper.getCroppedCanvas({
                                            width: 800, // New width for the cropped image
                                            height: 600 // New height for the cropped image
                                        });

                                        canvas.toBlob(function(blob) {
                                            const hiddenInput = document.getElementById('hiddenProfilePictureInput');
                                            const file = new File([blob], 'profile_picture.png', {
                                                type: 'image/png'
                                            });
                                            const dataTransfer = new DataTransfer();
                                            dataTransfer.items.add(file);
                                            hiddenInput.files = dataTransfer.files;

                                            const hiddenForm = document.getElementById('hiddenProfileForm');
                                            console.log(hiddenForm); // Check if this is null
                                            if (hiddenForm) {
                                                hiddenForm.submit();
                                            } else {
                                                console.error('Hidden form not found');
                                            }

                                            $('#cropImageModal').modal('hide');
                                        });
                                    }
                                });
                            });
                        </script>
                        <!-- Customer Name -->
                        <h3 class="m-3">{{ $user->name }}</h3>

                        <!-- Edit Profile Button -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#editProfileModal">Edit Profile</button>

                    </div>




                </div>
            </div>

            <!-- Customer Details Section -->
            <div class="col-md-8">
                <div class="card border">
                    <div class="card-header">
                        <h4>Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                            <li class="list-group-item"><strong>Phone Number:</strong> {{ $user->phone }}</li>
                            <li class="list-group-item"><strong>Address:</strong> {{ $user->address }}
                                {{ $user->postcode }} {{ $user->city }} {{ $user->state }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Order History Section -->
                <div class="card mt-4 border">
                    <div class="card-header">
                        <h4>Bookings</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @if (count($bookings) > 0)
                                @foreach ($bookings as $booking)
                                    <li class="list-group-item"><strong>{{ $booking->package->name }} :</strong>
                                        {{ $booking->event_date }} - {{ $booking->total_price }}</li>
                                @endforeach
                            @else
                                <li class="list-group-item">No bookings made.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit Profile Form -->
                    <form id="editProfileForm" method="post"
                        action="{{ route('users.update', Auth::user()->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" placeholder="Enter your name">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $user->phone }}" placeholder="Enter your phone number">
                        </div>
                        <!-- Additional Fields -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $user->address }}" placeholder="Enter your address">
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="text" class="form-control" id="postcode" name="postcode"
                                value="{{ $user->postcode }}" placeholder="Enter your postcode">
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ $user->city }}" placeholder="Enter your city">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state"
                                value="{{ $user->state }}" placeholder="Enter your state">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="editProfileForm">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

@endsection
