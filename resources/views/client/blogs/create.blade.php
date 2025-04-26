@extends('layouts.template')

@section('title', 'Create New Blog')

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
            display: none;
            margin-top: 10px;
            border-radius: 5px;
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

                        <a href="{{ route('client.home') }}"
                            class="sidebar-link {{ request()->routeIs('client.home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="{{ route('client.blogs.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.blogs.*') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> Blogs
                        </a>

                        <a href="{{ route('client.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.events.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt"></i> Events
                        </a>

                        <a href="{{ route('client.reservations.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.reservations*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Reservations
                        </a>

                        <a href="{{ route('client.favorites') }}"
                            class="sidebar-link {{ request()->routeIs('client.favorites*') ? 'active' : '' }}">
                            <i class="fas fa-heart"></i> Favorites
                        </a>

                        <a href="{{ route('client.reviews') }}"
                            class="sidebar-link {{ request()->routeIs('client.reviews*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Reviews
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Account</h6>

                        <a href="{{ route('profile.show') }}"
                            class="sidebar-link {{ request()->routeIs('client.profile*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profile
                        </a>

                        <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <!-- Tips Card -->
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title"><i class="fas fa-lightbulb text-warning me-2"></i>Blog Writing Tips</h6>
                            <ul class="small ps-3 mb-0">
                                <li class="mb-2">Use a compelling headline that captures attention</li>
                                <li class="mb-2">Include a relevant image to increase engagement</li>
                                <li class="mb-2">Keep paragraphs short for better readability</li>
                                <li class="mb-2">Use subheadings to organize your content</li>
                                <li class="mb-2">End with a call-to-action or question</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="dashboard-header mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-1">Create New Blog Post</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('client.blogs.index') }}">Blogs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('client.blogs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Blogs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Creation Form -->
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

                        <form action="{{ route('client.blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" required>
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
                                                {{ old('category') == $category->name ? 'selected' : '' }}>
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
                                    <small class="form-text text-muted">Recommended size: 1200 x 800 pixels (max
                                        2MB)</small>
                                    <img id="imagePreview" src="#" alt="Preview" class="preview-image">
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-4">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                <small class="form-text text-muted">A brief summary of your blog post (max 500 characters).
                                    If left empty, it will be generated from your content.</small>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label">Content <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control summernote" id="content" name="content" required>{{ old('content') }}</textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Create Blog Post</button>
                            </div>
                        </form>
                    </div>
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
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
@endpush
