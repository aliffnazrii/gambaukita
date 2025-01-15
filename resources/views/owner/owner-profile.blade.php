@extends('layout.owner')

@section('title', 'Admin Profile Page')

@section('content')

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

    <!-- Main Content -->
    <div class="container">
        <!-- Profile Image and Information -->
        <div class="card mb-3 p-3">
            <h3>Personal Information</h3>
            <div class="profile-pic-container mx-auto">
                @if ($user->picture == '')
                    <img src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-pic img-fluid">
                @else
                    <img src="{{ asset($user->picture) }}" alt="Profile Picture" class="profile-pic img-fluid">
                @endif

                <div class="edit-overlay" id="cameraIcon">
                    <i class="mdi mdi-camera"></i>
                </div>
                {{-- <input type="file" class="d-none" id="profilePictureInput" name="profile_picture"
                        required> --}}
                <input type="file" class="d-none" id="profilePictureInput" name="profile_picture" accept="image/*">

            </div>

            <form id="hiddenProfileForm" method="POST" action="{{ route('update.picture',$user->id) }}"
                enctype="multipart/form-data" style="display: none;">
                @csrf
                @method('PUT')
                <input type="file" class="d-none" id="hiddenProfilePictureInput" name="profile_picture">
            </form>

            <!-- Crop Image Modal -->
            <div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"
                aria-hidden="true">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Include Cropper.js -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
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
                                    width: 700, // Adjust this width as desired
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
            <form action="{{ route('owner.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-control">{{ $user->address }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

        <!-- Job Information -->
        <div class="card mb-3 p-3">
            <h3>Job Information</h3>
            <form>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" class="form-control" value="{{ $user->role }}" readonly>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="text" id="start_date" class="form-control" value="{{ $user->created_at }}" readonly>
                </div>

            </form>
        </div>

        <!-- Account Settings -->
        <div class="card mb-5 p-3">
            <h3>Update Password</h3>
            <form action="{{ route('owner.updatePassword', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Old Password -->
                <div class="form-group">
                    <label for="oldPassword">Old Password</label>
                    <input type="password" id="oldPassword" name="old_password" class="form-control"
                        placeholder="Enter old password" required>
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="changePassword">New Password</label>
                    <input type="password" id="changePassword" name="password" class="form-control"
                        placeholder="Enter new password" required>
                </div>

                <!-- Retype New Password -->
                <div class="form-group">
                    <label for="retypePassword">Retype New Password</label>
                    <input type="password" id="retypePassword" name="password_confirmation" class="form-control"
                        placeholder="Retype new password" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>

    </div>


@endsection
