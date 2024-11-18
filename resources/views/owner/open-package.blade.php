@extends('layout.owner')

@section('title', 'Package Details')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <div class="container my-4">
        <div class="card m-auto">
            <div class="card-header">
                <h3>Package Details</h3>
            </div>
            <div class="card-body m-auto ">


                <form action="{{ route('packages.update', $package->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($package->images->isNotEmpty())
                        <label class="form-label">Package Images</label>
                        <div class="row m-4">
                            {{-- @foreach ($package->name as $image) --}}
                            <div class="col-md-6 m-auto">
                                <img src="{{ $package->images->first()->image_url }}" style="width:700px" class="img-thumbnail"
                                    alt="Package Image">
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="packagestatus" class="form-label">Package Status</label>
                        <select class="form-control" name="status">
                            <option value="active" {{ $package->status == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive"{{ $package->status == 'inactive' ? 'selected' : '' }}>
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
                        <textarea id="packageDescription" value="" name="description" class="form-control" rows="5" required>{{ $package->description }}</textarea>
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
                    <div class="mb-3">
                        <label for="packageImage" class="form-label">Thumbnail</label>
                        <input type="file" value="{{ $package->images->first()->image_url }}" id="uploadImages"
                            accept="image/*" name="images[]" class="form-control" multiple>
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
                                        <button type="button" id="cropImage" class="btn btn-primary">Crop &
                                            Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('owner.package') }}" class="btn btn-primary">Back</a>


                    </div>
                </form>



                {{-- <p><strong>Description:</strong> {{ $package->description }}</p>
                <p><strong>Price:</strong> ${{ $package->price }}</p>
                <p><strong>Duration:</strong> {{ $package->duration }} days</p> --}}

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
@endsection
