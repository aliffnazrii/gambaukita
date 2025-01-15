@extends('layout.owner')

@section('title', 'Package Management')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        .custom-textarea {
            height: 150px;
            /* You can adjust the height to any value you prefer */
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 20px;
            color: #434343;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            resize: vertical;
        }



        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f6f6f6;
        }
    </style>

    <!-- Main Content -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Add Package</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('packages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="packageName" class="form-label">Package Name</label>
                        <input type="text" id="packageName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="packageDescription" class="form-label">Description</label>
                        <textarea id="packageDescription" name="description" class="form-control custom-textarea" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Features" class="form-label">Features</label>
                        <textarea id="features" name="features" class="form-control custom-textarea" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="packagePrice" class="form-label">Price</label>
                        <input type="number" id="packagePrice" name="price" class="form-control " required>
                    </div>
                    <div class="mb-3">
                        <label for="packageDuration" class="form-label">Duration (Days)</label>
                        <input type="number" id="packageDuration" name="duration" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="packageImage" class="form-label">Thumbnail</label>
                        <input type="file" id="uploadImages" accept="image/*" name="images[]" class="form-control"
                            multiple>
                        <input type="hidden" id="croppedImagesData" name="cropped_images">

                        <div id="previewContainer" class="mt-3">
                        </div>

                        <!-- Modal for Cropping -->
                        <div class="modal fade" id="cropModal" tabindex="-1" role="dialog"
                            aria-labelledby="cropModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="img-container">
                                            <img id="imageToCrop" src="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="button" id="cropImage" class="btn btn-primary">Crop & Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <!-- Catalogue Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Current Packages</h3>
            </div>
            <div class="card-body">
                <table id="catalogueTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->duration }}</td>
                                <td>RM {{ $package->price }}</td>
                                <td>
                                    <a href="{{ route('package.view', $package->id) }}"
                                        class="btn btn-warning col-12">Edit</a>
                                    {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#basicModal{{ $package->id }}">Deactivate</button> --}}
                                </td>
                            </tr>




                            <!-- Delete Modal -->
                            <div class="modal fade" id="basicModal{{ $package->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Deactivate Confirmation</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Are you sure to deactivate this content?</div>
                                        <div class="modal-footer">
                                            <form action="{{ route('packages.destroy', $package->id) }}" method="post">
                                                @method('PUT')
                                                @csrf

                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script>
        let cropper;
        let currentFileIndex = 0;
        let filesToProcess = [];
        const croppedImages = [];

        document.getElementById('uploadImages').addEventListener('change', function(event) {
            filesToProcess = Array.from(event.target.files);
            currentFileIndex = 0;
            processNextImage();
        });

        function processNextImage() {
            if (currentFileIndex < filesToProcess.length) {
                const file = filesToProcess[currentFileIndex];
                const reader = new FileReader();
                const imageElement = document.getElementById('imageToCrop');

                reader.onload = function(e) {
                    imageElement.src = e.target.result;
                    $('#cropModal').modal('show');
                };
                reader.readAsDataURL(file);

                $('#cropModal').on('shown.bs.modal', function() {
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(imageElement, {
                        aspectRatio: 4 / 3, // Adjust this if you want a different aspect ratio
                        viewMode: 1
                    });
                });
            }
        }

        document.getElementById('cropImage').addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 400, // Adjust this width as desired
                height: 300 // Adjust this height as desired
            });

            canvas.toBlob((blob) => {
                if (!blob) {
                    console.error('Canvas is empty. Cropping failed.');
                    return;
                }

                // Create a new File object to replace the original file input
                const croppedFile = new File([blob], `cropped_image_${currentFileIndex}.jpg`, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                // Clear the file input
                const fileInput = document.getElementById('uploadImages');
                const dataTransfer = new DataTransfer();

                // Add the cropped image to the file input
                dataTransfer.items.add(croppedFile);
                fileInput.files = dataTransfer.files;

                // Display the cropped image preview
                const previewUrl = URL.createObjectURL(blob);
                const previewContainer = document.getElementById('previewContainer');

                const imgContainer = document.createElement('div');
                imgContainer.classList.add('img-preview-container', 'd-inline-block', 'position-relative',
                    'mr-2', 'mb-2');

                const imgPreview = document.createElement('img');
                imgPreview.src = previewUrl;
                imgPreview.classList.add('img-thumbnail');
                imgPreview.style.maxWidth = '150px';

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0',
                    'right-0');
                deleteButton.style.transform = 'translate(50%, -50%)';
                deleteButton.textContent = 'x';

                deleteButton.addEventListener('click', function() {
                    imgContainer.remove();
                    croppedImages.splice(croppedImages.indexOf(blob), 1); // Remove blob from array
                });

                imgContainer.appendChild(imgPreview);
                imgContainer.appendChild(deleteButton);
                previewContainer.appendChild(imgContainer);

                // Move to the next image
                currentFileIndex++;
                $('#cropModal').modal('hide');
                processNextImage();
            });
        });
    </script>



    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        // DataTables initialization
        $(document).ready(function() {
            $('#catalogueTable').DataTable();
        });
    </script>
@endsection
