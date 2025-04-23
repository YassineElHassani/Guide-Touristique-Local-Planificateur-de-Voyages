@extends('admin.layout')

@section('title', 'Create Blog Post')

@section('heading', 'Create Blog Post')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor {
            border-radius: 0.5rem;
        }

        .note-toolbar {
            background-color: #f8f9fa;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .preview-img {
            max-height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .blog-form-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .blog-tip-card {
            border-radius: 1rem;
            border: none;
            background-color: #f0f9ff;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Blog Post Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label">Blog Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title') }}" placeholder="Enter blog title" required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="12" placeholder="Write blog content here...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Enter a short excerpt">{{ old('excerpt') }}</textarea>
                            <small class="form-text text-muted">Optional. If left blank, an excerpt will be generated from
                                the content.</small>
                            @error('excerpt')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Categories -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Category</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}"
                                                {{ old('category') == $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                        <option value="new">+ Add New Category</option>
                                    </select>
                                </div>

                                <div id="new-category-group" class="mb-3" style="display: none;">
                                    <label for="new_category" class="form-label">New Category Name</label>
                                    <input type="text" class="form-control" id="new_category" name="new_category"
                                        value="{{ old('new_category') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Featured Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*">
                                    <small class="form-text text-muted">Recommended size: 1200 x 628 pixels</small>
                                    @error('image')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-2 d-none" id="imagePreviewContainer">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Blog Post
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category selection handler
            document.getElementById('category').addEventListener('change', function() {
                const newCategoryGroup = document.getElementById('new-category-group');
                if (this.value === 'new') {
                    newCategoryGroup.style.display = 'block';
                } else {
                    newCategoryGroup.style.display = 'none';
                }
            });

            // Image preview
            document.getElementById('image').addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        document.getElementById('imagePreview').src = event.target.result;
                        document.getElementById('imagePreviewContainer').classList.remove('d-none');
                    }

                    reader.readAsDataURL(file);
                }
            });
        });

        $(document).ready(function() {
            // Initialize Summernote editor
            $('#content').summernote({
                placeholder: 'Start writing your blog post here...',
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // You can implement image upload to server here
                        for (let i = 0; i < files.length; i++) {
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                const img = document.createElement('img');
                                img.src = reader.result;
                                $('#content').summernote('insertNode', img);
                            }
                            reader.readAsDataURL(files[i]);
                        }
                    }
                }
            });

            // Image preview
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result);
                        $('#image-preview-container').show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview-container').hide();
                }
            });
        });
    </script>
@endpush