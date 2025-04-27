@extends('layouts.template')

@section('title', 'Edit Blog: ' . $blog->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border-radius: 0.25rem;
            border-color: #ced4da;
        }

        .preview-image {
            max-height: 200px;
            width: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="dashboard-sidebar p-4">
                    <!-- User Info -->
                    <div class="d-flex align-items-center mb-4">
                        @php
                            $avatar = Auth::user()->picture
                                ? (Str::startsWith(Auth::user()->picture, 'http')
                                    ? Auth::user()->picture
                                    : asset('storage/' . Auth::user()->picture))
                                : asset('/assets/images/default-avatar.png');
                        @endphp
                        <img src="{{ $avatar }}" alt="{{ Auth::user()->first_name }}" class="user-avatar me-3">
                        <div>
                            <h5 class="mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                            <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Main</h6>

                        <a href="{{ route('guide.home') }}"
                            class="sidebar-link {{ request()->routeIs('guide.home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="{{ route('guide.blogs.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.blogs.*') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> Blogs
                        </a>

                        <a href="{{ route('guide.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.events.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt"></i> Events
                        </a>

                        <a href="{{ route('guide.reservations.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.reservations*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Reservations
                        </a>

                        <a href="{{ route('guide.reviews') }}"
                            class="sidebar-link {{ request()->routeIs('guide.reviews*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Reviews
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Account</h6>

                        <a href="{{ route('profile.show') }}"
                            class="sidebar-link {{ request()->routeIs('guide.profile*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profile
                        </a>

                        <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <!-- Blog Info -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Blog Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block">Created</small>
                                <span>{{ $blog->created_at->format('M d, Y') }}</span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Last Updated</small>
                                <span>{{ $blog->updated_at->format('M d, Y') }}</span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge {{ $blog->published ? 'bg-success' : 'bg-warning' }}">
                                    {{ $blog->published ? 'Published' : 'Draft' }}
                                </span>
                                @if ($blog->featured)
                                    <span class="badge bg-warning ms-1">Featured</span>
                                @endif
                            </div>

                            <div>
                                <small class="text-muted d-block">Stats</small>
                                <div class="d-flex justify-content-between mt-1">
                                    <span><i class="fas fa-eye me-1"></i> {{ number_format($blog->views) }}</span>
                                    <span><i class="fas fa-comments me-1"></i> {{ $blog->comments->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('guide.blogs.show', $blog->slug) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-1"></i> View Blog
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteBlogModal">
                            <i class="fas fa-trash me-1"></i> Delete Blog
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="dashboard-header mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-1">Edit Blog Post</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('guide.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('guide.blogs.index') }}">Blogs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('guide.blogs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Blogs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Edit Form -->
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('guide.blogs.update', $blog->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $blog->title) }}" required>
                                <small class="form-text text-muted">Choose a compelling title (max 255 characters)</small>
                            </div>

                            <div class="row mb-4">
                                <!-- Category -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}"
                                                {{ old('category', $blog->category) == $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Featured Image -->
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Featured Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*" onchange="previewImage(this)">
                                    <small class="form-text text-muted">Leave empty to keep current image (max 2MB)</small>

                                    @if ($blog->image)
                                        <div class="mt-2">
                                            <img id="imagePreview" src="{{ asset('storage/' . $blog->image) }}"
                                                alt="{{ $blog->title }}" class="preview-image">
                                        </div>
                                    @else
                                        <img id="imagePreview" src="#" alt="Preview" class="preview-image"
                                            style="display: none;">
                                    @endif
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-4">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                <small class="form-text text-muted">A brief summary of your blog post (max 500 characters).
                                    If left empty, it will be generated from your content.</small>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control summernote" id="content" name="content" required>{{ old('content', $blog->content) }}</textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Update Blog Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Blog Modal -->
    <div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Blog Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this blog post: <strong>{{ $blog->title }}</strong>?</p>
                    <p class="text-danger">This action cannot be undone and will also delete all associated comments.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('guide.blogs.destroy', $blog->slug) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Write your blog content here...',
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        function previewImage(input) {
            var preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
