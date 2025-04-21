@extends('admin.layout')

@section('title', 'Edit Blog Post')

@section('heading', 'Edit Blog Post')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
    <li class="breadcrumb-item active">Edit</li>
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

        .current-img {
            max-height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
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
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Edit Blog Post</h5>
            <div>
                <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-sm btn-info" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i> View on Site
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blogs.update', $blog->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label">Blog Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $blog->title) }}" placeholder="Enter blog title" required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label">Blog Content <span class="text-danger">*</span></label>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <textarea id="content" name="content" required>{{ old('content', $blog->content) }}</textarea>
                                </div>
                            </div>
                            @error('content')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Enter a short excerpt">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <small class="form-text text-muted">Optional. If left blank, an excerpt will be generated from
                                the content.</small>
                            @error('excerpt')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Info -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Blog Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Author:</strong>
                                            @if ($blog->user)
                                                {{ $blog->user->first_name }} {{ $blog->user->last_name }}
                                            @else
                                                Unknown
                                            @endif
                                        </p>
                                        <p class="mb-1"><strong>Created:</strong>
                                            {{ $blog->created_at->format('M d, Y \a\t H:i') }}</p>
                                        <p class="mb-1"><strong>Last Updated:</strong>
                                            {{ $blog->updated_at->format('M d, Y \a\t H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Views:</strong> {{ number_format($blog->views) }}</p>
                                        <p class="mb-1"><strong>Comments:</strong> {{ $blog->comments_count ?? 'N/A' }}
                                        </p>
                                        <p class="mb-1"><strong>Slug:</strong> {{ $blog->slug }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Publishing Options -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Publishing Options</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="published" name="published"
                                        {{ old('published', $blog->published) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="published">Published</label>
                                    <small class="d-block text-muted">Uncheck to save as draft</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured"
                                        {{ old('featured', $blog->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Featured</label>
                                    <small class="d-block text-muted">Featured posts appear in highlighted areas</small>
                                </div>
                            </div>
                        </div>

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
                                                {{ old('category', $blog->category) == $category->name ? 'selected' : '' }}>
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
                                @if ($blog->image)
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                                class="img-fluid rounded">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_image"
                                                    name="remove_image">
                                                <label class="form-check-label" for="remove_image">Remove current
                                                    image</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="image"
                                        class="form-label">{{ $blog->image ? 'Replace Image' : 'Upload Image' }}</label>
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
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Update Blog Post
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
            const categorySelect = document.getElementById('category');
            const newCategoryGroup = document.getElementById('new-category-group');

            categorySelect.addEventListener('change', function() {
                if (this.value === 'new') {
                    newCategoryGroup.style.display = 'block';
                } else {
                    newCategoryGroup.style.display = 'none';
                }
            });

            // Set initial state of new category field
            if (categorySelect.value === 'new') {
                newCategoryGroup.style.display = 'block';
            }

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
                placeholder: 'Write your blog post here...',
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
