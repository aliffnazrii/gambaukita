@extends('layout.client')

@section('title', 'Portfolio')

@section('content')

<div class="card card-body mt-4">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-body text-center">
                    <h1>Portfolio</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card border">
                    <div class="card-body border">
                        <h4 class="card-title">Upload Your Work</h4>
                        <form id="uploadForm" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="fileUpload" class="form-label">Drag and drop files here or click to upload</label>
                                <div id="dropArea" class="drop-area">
                                    <input type="file" id="fileUpload" name="files[]" multiple class="d-none" />
                                    <p>Drag & Drop your files here</p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card border">
                    <div class="card-body border">
                        <h4 class="card-title">Your Uploaded Files</h4>
                        <ul id="fileList" class="list-group">
                            <!-- Uploaded files will be listed here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const dropArea = document.getElementById('dropArea');
    const fileUpload = document.getElementById('fileUpload');
    const fileList = document.getElementById('fileList');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    // Remove highlight when item is no longer dragged over
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);
    dropArea.addEventListener('click', () => fileUpload.click());

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropArea.classList.add('highlight');
    }

    function unhighlight() {
        dropArea.classList.remove('highlight');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    fileUpload.addEventListener('change', (e) => {
        const files = e.target.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        [...files].forEach(uploadFile);
    }

    function uploadFile(file) {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item';
        listItem.textContent = file.name;
        fileList.appendChild(listItem);
    }
</script>
@endsection