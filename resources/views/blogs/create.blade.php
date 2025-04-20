@extends('layouts.template')

@section('title', 'Create Blog Post')

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
    <!-- Header Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-3">Create a New Blog Post</h1>
                    <p>Share your travel experiences, tips, and stories with our community.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card blog-form-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                <div class="form-text">A catchy title will attract more readers.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="2">{{ old('excerpt') }}</textarea>
                                <div class="form-text">A brief summary of your blog post (max 500 characters). If left empty, it will be generated from your content.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                    <option value="Adventure" {{ old('category') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="Cultural" {{ old('category') == 'Cultural' ? 'selected' : '' }}>Cultural</option>
                                    <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food & Cuisine</option>
                                    <option value="Travel Tips" {{ old('category') == 'Travel Tips' ? 'selected' : '' }}>Travel Tips</option>
                                    <option value="Budget Travel" {{ old('category') == 'Budget Travel' ? 'selected' : '' }}>Budget Travel</option>
                                    <option value="Luxury Travel" {{ old('category') == 'Luxury Travel' ? 'selected' : '' }}>Luxury Travel</option>
                                    <option value="Nature" {{ old('category') == 'Nature' ? 'selected' : '' }}>Nature & Outdoors</option>
                                    <option value="City Guides" {{ old('category') == 'City Guides' ? 'selected' : '' }}>City Guides</option>
                                    <option value="Photography" {{ old('category') == 'Photography' ? 'selected' : '' }}>Photography</option>
                                    <option value="Solo Travel" {{ old('category') == 'Solo Travel' ? 'selected' : '' }}>Solo Travel</option>
                                    <option value="Family Travel" {{ old('category') == 'Family Travel' ? 'selected' : '' }}>Family Travel</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Cover Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Recommended size: 1200x800 pixels (16:9 ratio).</div>
                                
                                <div class="mt-3" id="image-preview-container" style="display: none;">
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
                                <textarea id="content" name="content" required>{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card blog-form-card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Publishing Options</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="published" name="published" value="1" {{ old('published', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">Publish Immediately</label>
                                <div class="form-text">If unchecked, the post will be saved as a draft.</div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">Mark as Featured</label>
                                <div class="form-text">Featured posts appear in the featured section on the blog homepage.</div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Blog Post</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-4">
                <!-- Tips Card -->
                <div class="card blog-tip-card sticky-top mb-4" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Tips for a Great Blog Post</h5>
                        
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                <i class="fas fa-heading"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Catchy Title</h6>
                                <p class="text-muted small mb-0">Create an engaging title that grabs attention and accurately represents your content.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                <i class="fas fa-images"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Use Quality Images</h6>
                                <p class="text-muted small mb-0">Include high-quality photos that showcase your experience and engage readers.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                <i class="fas fa-paragraph"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Clear Structure</h6>
                                <p class="text-muted small mb-0">Use headings, subheadings, and short paragraphs to improve readability.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Include Practical Tips</h6>
                                <p class="text-muted small mb-0">Provide actionable advice and insider tips that readers can use in their travels.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Be Authentic</h6>
                                <p class="text-muted small mb-0">Share your genuine experiences, including both highlights and challenges.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog Ideas Card -->
                <div class="card blog-form-card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Blog Post Ideas</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Top 10 hidden gems in [destination]</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> A perfect 3-day itinerary for [city]</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Budget travel guide: How to explore [place] on $XX per day</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Local cuisine: Must-try dishes in [destination]</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Off-season travel: Why you should visit [place] in [month]</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Cultural etiquette: Dos and don'ts in [country]</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Photo guide: Best spots for Instagram-worthy pictures</li>
                            <li class="list-group-item border-0 px-0"><i class="fas fa-check-circle text-success me-2"></i> Solo travel tips for [destination]</li>
                        </ul>
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