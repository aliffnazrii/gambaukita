@extends('layout.client')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
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
