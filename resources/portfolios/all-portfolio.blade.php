@extends('layout.owner')

@section('title', 'Portfolio Management')


@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
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
    </head>

    <body>


        <div class="card mt-3 ">
            <h3>Add / Edit Portfolio</h3>
            @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}
                        </li>
                    @endforeach

                </ul>
            @endif
            <form action="{{ route('portfolios.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Portfolio Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="packageImage" class="form-label">Masterpiece</label>
                    <input type="file" id="uploadImages" accept="image/*" name="images[]" class="form-control" multiple>
                    <input type="hidden" id="croppedImagesData" name="cropped_images">

                    <div id="previewContainer" class="mt-3">
                    </div>

                    <!-- Modal for Cropping -->
                    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel"
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
                                    <button type="button" id="cropImage" class="btn btn-primary">Crop & Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

        <!-- Catalogue Table -->
        <div class="card">
            <h3>Current Portfolios</h3>
            <table id="catalogueTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="col-1">ID</th>
                        <th>Title</th>
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Data (Dynamic in real implementation) -->
                    @foreach ($portfolios as $portfolio)
                        <tr>
                            <td class="col-1">{{ $portfolio->id }}</td>
                            <td>{{ $portfolio->title }}</td>
                            <td class="col-2">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#EditModal{{ $portfolio->id }}">Edit</button>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#basicModal{{ $portfolio->id }}">Delete</button>

                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="EditModal{{ $portfolio->id }}">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">View Portfolio</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6 m-auto"> <img src="{{ $portfolio->image_url }}"
                                                        class="col-md text-center" alt="Images"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <form action="{{ route('portfolios.update', $portfolio->id) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="name">Portfolio Title</label>
                                                            <input type="text" class="form-control" name="title"
                                                                value="{{ $portfolio->title }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="desc">Description</label>
                                                            <textarea id="packageDescription" name="description" class="form-control" required>{{ $portfolio->description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Image URL">Image URL</label>
                                                            <input type="text" class="form-control" name="image"
                                                                value="{{ $portfolio->image_url }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="active" class="form-select">Active</option>
                                                                <option value="inactive">Inactive</option>

                                                            </select>

                                                        </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal -->
                            <div class="modal fade" id="basicModal{{ $portfolio->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Confirmation</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Are you sure to delete this content?</div>
                                        <div class="modal-footer">
                                            <form action="{{ route('portfolios.destroy', $portfolio->id) }}"
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
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#catalogueTable').DataTable(); // Initialize DataTables

            });



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
    @endsection
