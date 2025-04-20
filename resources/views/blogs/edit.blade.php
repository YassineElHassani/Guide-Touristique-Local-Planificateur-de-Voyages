@extends('layouts.template')

@section('title', 'Edit Blog Post')

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
    <!-- Header Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-3">Edit Blog Post</h1>
                    <p>Update your travel story and make it even better.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('blogs.update', $blog->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card blog-form-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                <div class="form-text">A brief summary of your blog post (max 500 characters). If left empty, it will be generated from your content.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category', $blog->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                    <option value="Adventure" {{ old('category', $blog->category) == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="Cultural" {{ old('category', $blog->category) == 'Cultural' ? 'selected' : '' }}>Cultural</option>
                                    <option value="Food" {{ old('category', $blog->category) == 'Food' ? 'selected' : '' }}>Food & Cuisine</option>
                                    <option value="Travel Tips" {{ old('category', $blog->category) == 'Travel Tips' ? 'selected' : '' }}>Travel Tips</option>
                                    <option value="Budget Travel" {{ old('category', $blog->category) == 'Budget Travel' ? 'selected' : '' }}>Budget Travel</option>
                                    <option value="Luxury Travel" {{ old('category', $blog->category) == 'Luxury Travel' ? 'selected' : '' }}>Luxury Travel</option>
                                    <option value="Nature" {{ old('category', $blog->category) == 'Nature' ? 'selected' : '' }}>Nature & Outdoors</option>
                                    <option value="City Guides" {{ old('category', $blog->category) == 'City Guides' ? 'selected' : '' }}>City Guides</option>
                                    <option value="Photography" {{ old('category', $blog->category) == 'Photography' ? 'selected' : '' }}>Photography</option>
                                    <option value="Solo Travel" {{ old('category', $blog->category) == 'Solo Travel' ? 'selected' : '' }}>Solo Travel</option>
                                    <option value="Family Travel" {{ old('category', $blog->category) == 'Family Travel' ? 'selected' : '' }}>Family Travel</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Cover Image</label>
                                
                                @if($blog->image)
                                    <div class="mb-3">
                                        <p class="mb-2">Current image:</p>
                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Cover Image" class="img-fluid current-img">
                                    </div>
                                @endif
                                
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Upload a new image to replace the current one, or leave empty to keep the current image.</div>
                                
                                <div class="mt-3" id="image-preview-container" style="display: none;">
                                    <p class="mb-2">New image preview:</p>
                                    <img src="" alt="Image Preview" id="image-preview" class="img-fluid preview-img">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card blog-form-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Blog Content <span class="text-danger">*</span></h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <textarea id="content" name="content" required>{{ old('content', $blog->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card blog-form-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Publishing Options</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="published" name="published" value="1" {{ old('published', $blog->published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">Published</label>
                                <div class="form-text">If unchecked, the post will be saved as a draft.</div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $blog->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">Mark as Featured</label>
                                <div class="form-text">Featured posts appear in the featured section on the blog homepage.</div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('blogs.my-blogs') }}" class="btn btn-outline-secondary">Cancel</a>
                                <div>
                                    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteBlogModal">
                                        Delete Post
                                    </button>
                                    <button type="submit" class="btn btn-primary">Update Blog Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-labelledby="deleteBlogModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteBlogModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this blog post?</p>
                                <p><strong>{{ $blog->title }}</strong></p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('blogs.destroy', $blog->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Blog Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
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