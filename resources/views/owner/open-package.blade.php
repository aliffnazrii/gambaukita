@extends('layout.owner')

@section('title', 'Package Details')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Bootstrap 4 Styling -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

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


    <div class="row p-0 m-0 mt-3 ">
        <div class="card col-12 m-auto my-3">
            <div class="card-header">
                <h3>{{ $package->name }}</h3>
            </div>


            <div class="card-body m-auto ">
                <form action="{{ route('packages.update', $package->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($package->images->isNotEmpty())
                        <div class="row m-4">
                            <div class="col-md-12 m-auto">
                                <!-- Carousel -->
                                <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($package->images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image_url) }}"
                                                    class="d-block w-100 img-thumbnail" alt="Image {{ $index + 1 }}">
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($package->images->count() > 1)
                                        <!-- Carousel controls -->
                                        <a class="carousel-control-prev" href="#imageCarousel" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#imageCarousel" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="packagestatus" class="form-label">Package Status</label>
                        <select class="form-control" name="status">
                            <option value="active" {{ $package->status == 'Active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive"{{ $package->status == 'Inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="packageName" class="form-label">Package Name</label>
                        <input type="text" id="packageName" value="{{ $package->name }}" name="name"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="packageDescription" class="form-label">Description</label>
                        <textarea id="packageDescription" value="" name="description" class="form-control custom-textarea" rows="5"
                            required>{{ $package->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="features" class="form-label">Features</label>
                        <textarea id="features" name="features" class="form-control custom-textarea" rows="5" required>{{ $package->features }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="packagePrice" class="form-label">Price</label>
                        <input type="number" value="{{ $package->price }}" id="packagePrice" name="price"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="packageDuration" class="form-label">Duration (Days)</label>
                        <input type="number" value="{{ $package->duration }}" id="packageDuration" name="duration"
                            class="form-control" required>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('owner.package') }}" class="btn btn-primary">Back</a>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row p-0 mx-0 my-3">
        <div class="card col-12 m-auto my-4">
            <div class="card-header">
                <h3> Images</h3>
            </div>
            <div class="card-body m-auto m-5">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cropModalAdd">Add</button>
                <!-- Modal for Image Upload and Cropping -->
                <div class="modal fade" id="cropModalAdd" tabindex="-1" role="dialog" aria-labelledby="cropModalAddLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cropModalAddLabel">Upload and Crop Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- File Upload Input -->
                                <form action="{{ route('package-images.store') }}" method="post"
                                    enctype="multipart/form-data" id="imageForm">
                                    @csrf
                                    <input type="file" name="image" id="imageUpload" accept="image/*"
                                        class="form-control">
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <!-- Hidden field to store the cropped image -->
                                    <input type="hidden" name="cropped_image" id="croppedImage">

                                    <!-- Cropper Container -->
                                    <div id="cropContainer" class="mt-3" style="max-width: 100%; display: none;">
                                        <img id="imageToCrop" src="#" alt="Image to crop">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="saveCroppedImage" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>


                <table id="catalogueTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($package->images)
                            @foreach ($package->images as $image)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $image->image_url }}</td>
                                    <td>
                                        <!-- View Button: Set data-image-url attribute to the image URL -->
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#viewModal{{ $image->id }}"
                                            data-image-url="{{ asset($image->image_url) }}">
                                            View
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#basicModal{{ $image->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="basicModal{{ $image->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="basicModalLabel">Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('package-images.destroy', $image->id) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Image Modal (Unique for each image) -->
                                <div class="modal fade" id="viewModal{{ $image->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="viewModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $image->id }}">View Image
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <!-- Image Container (the image will be dynamically inserted here) -->
                                                <img id="imageInModal{{ $image->id }}"
                                                    src="{{ asset($image->image_url) }}" class="img-fluid"
                                                    alt="Image to View">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <script>
                                $(document).ready(function() {
                                    // When "View" button is clicked, update the modal image
                                    $('[data-toggle="modal"]').on('click', function(event) {
                                        var button = $(this); // Button that triggered the modal
                                        var imageUrl = button.data('image-url'); // Extract image URL from data-* attribute
                                        var targetModalId = button.data('target'); // Get the target modal ID
                                        var modal = $(targetModalId);

                                        // Update the modal image source
                                        modal.find('img').attr('src', imageUrl); // Set image source dynamically
                                    });
                                });
                            </script>


                            <!-- View Image Modal -->
                            <div class="modal fade" id="viewModal{{ $image->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Image Container (the image will be dynamically inserted here) -->
                                            <img id="imageInModal{{ $image->id }}" src="" class="img-fluid"
                                                alt="Image to View">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    // When "View" button is clicked, update the modal image
                                    $('#viewModal{{ $image->id }}').on('show.bs.modal', function(event) {
                                        var button = $(event.relatedTarget); // Button that triggered the modal
                                        var imageUrl = button.data('image-url'); // Extract image URL from data-* attribute
                                        var modal = $(this);
                                        modal.find('#imageInModal{{ $image->id }}').attr('src',
                                            imageUrl); // Update the modal image source
                                    });
                                });
                            </script>

                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- <!-- Modal for Cropping -->
    <div class="modal fade" id="cropModalAdd" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel"
        aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="cropImage" class="btn btn-primary">Crop &
                        Upload</button>
                </div>
            </div>
        </div>
    </div> --}}


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap 4 JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#catalogueTable').DataTable(); // Initialize DataTable on the table
        });
    </script>

    {{-- <script>
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
    </script> --}}

    <!-- Include jQuery and Bootstrap (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        $(document).ready(function() {
            var cropper;
            var imageUpload = $('#imageUpload');
            var saveCroppedImage = $('#saveCroppedImage');
            var croppedImageField = $('#croppedImage'); // Hidden input field to store cropped image

            // Static crop box dimensions (for example 400x400)
            var cropBoxWidth = 400;
            var cropBoxHeight = 400;

            // Static canvas dimensions (same as crop box size)
            var canvasWidth = 400;
            var canvasHeight = 400;

            // Trigger file input when "Add" button is clicked
            $('#cropModalAdd').on('shown.bs.modal', function() {
                imageUpload.trigger('click');
            });

            // When a file is selected, load it in the preview area
            imageUpload.change(function(event) {
                var file = event.target.files[0];
                if (file && file.type.startsWith('image')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Show the image preview
                        $('#imagePreview').attr('src', e.target.result).show();
                        // Show the cropping container
                        $('#cropContainer').show();

                        // Initialize cropper on the image
                        var imageToCrop = $('#imageToCrop');
                        imageToCrop.attr('src', e.target.result);
                        if (cropper) {
                            cropper.destroy(); // Destroy previous cropper instance if exists
                        }

                        // Create an image object to load the file and scale it down if necessary
                        var img = new Image();
                        img.src = e.target.result;
                        img.onload = function() {
                            // Check if the image is larger than the max width/height (e.g., 2000px)
                            var maxSize = 2000;
                            var scaleFactor = 1;

                            if (img.width > maxSize || img.height > maxSize) {
                                // Scale down the image while maintaining aspect ratio
                                if (img.width > img.height) {
                                    scaleFactor = maxSize / img.width;
                                } else {
                                    scaleFactor = maxSize / img.height;
                                }

                                // Resize the image dimensions
                                img.width = img.width * scaleFactor;
                                img.height = img.height * scaleFactor;
                            }

                            // Initialize the cropper after resizing the image
                            cropper = new Cropper(imageToCrop[0], {
                                aspectRatio: 4 / 3, // Maintain aspect ratio (1:1 for square crop)
                                viewMode: 1, // Crop in bounded box
                                autoCropArea: 0.8, // Initial crop area
                                responsive: true,
                                cropBoxResizable: false, // Disable resizing the crop box
                                ready: function() {
                                    // Set the crop box to the desired static size (fixed width and height)
                                    cropper.setCropBoxData({
                                        left: (cropper.getContainerData()
                                            .width - cropBoxWidth) / 2,
                                        top: (cropper.getContainerData()
                                            .height - cropBoxHeight) / 2,
                                        width: cropBoxWidth,
                                        height: cropBoxHeight
                                    });
                                }
                            });
                        };
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please select a valid image.');
                }
            });

            // Save the cropped image and submit the form
            saveCroppedImage.click(function() {
                if (cropper) {
                    // Get the cropped image as a canvas with static width and height
                    var croppedCanvas = cropper.getCroppedCanvas({
                        width: canvasWidth, // Static canvas width
                        height: canvasHeight // Static canvas height
                    });

                    // Convert the cropped image to a Blob (file)
                    croppedCanvas.toBlob(function(blob) {
                        // Create a FormData object to send the file
                        var formData = new FormData();
                        formData.append('image', blob); // Add the file to the form data
                        formData.append('package_id',
                            '{{ $package->id }}'); // Send the package ID
                        formData.append('_token', '{{ csrf_token() }}'); // Include CSRF token

                        // Send the form data via AJAX
                        $.ajax({
                            url: '{{ route('package-images.store') }}',
                            type: 'POST',
                            data: formData,
                            processData: false, // Don't process the data
                            contentType: false, // Don't set content type
                            success: function(response) {
                                // On success, close the modal and refresh the page
                                $('#cropModalAdd').modal('hide');
                                location
                                    .reload(); // Optionally, reload the page to show the new image
                            },
                            error: function(response) {
                                // Handle error
                                alert('Error saving image.');
                            }
                        });
                    }, 'image/png'); // Specify the image type (PNG in this case)
                }
            });
        });
    </script>






@endsection
