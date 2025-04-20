@extends('layouts.template')

@section('title', 'Blog Search Results')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">Search Results</h1>
                    <p class="mb-5">
                        @if($query)
                            Showing results for "{{ $query }}"
                            @if($categoryFilter)
                                in {{ $categoryFilter }}
                            @endif
                        @else
                            @if($categoryFilter)
                                Showing filtered results in {{ $categoryFilter }}
                            @else
                                Showing all blog posts
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Blog Posts -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blogs</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                            </ol>
                        </nav>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-sort me-1"></i> Sort By
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item active" href="#">Most Recent</a></li>
                                    <li><a class="dropdown-item" href="#">Most Popular</a></li>
                                    <li><a class="dropdown-item" href="#">A-Z</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <form action="{{ route('blogs.search') }}" method="GET" class="row g-3">
                                <div class="col-md-6">
                                    <label for="query" class="form-label">Search</label>
                                    <input type="text" class="form-control" id="query" name="query" placeholder="Search blogs..." value="{{ $query }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ $categoryFilter == $category ? 'selected' : '' }}>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Results Count -->
                    <p class="text-muted mb-4">Found {{ count($blogs) }} results</p>
                    
                    @if(count($blogs) > 0)
                        <div class="row g-4">
                            @foreach($blogs as $blog)
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <img src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            @if($blog->category)
                                                <span class="badge bg-primary mb-2">{{ $blog->category }}</span>
                                            @endif
                                            <h5 class="card-title">{{ $blog->title }}</h5>
                                            <p class="card-text text-muted">{{ $blog->excerpt }}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $blog->user->picture ?? asset('/assets/images/default-avatar.png') }}" class="rounded-circle me-2" width="24" height="24" alt="{{ $blog->user->first_name }} {{ $blog->user->last_name }}">
                                                    <span class="small">{{ $blog->user->first_name }} {{ $blog->user->last_name }}</span>
                                                </div>
                                                <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-outline-primary mt-3">Read More</a>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="d-flex justify-content-between text-muted small">
                                                <span><i class="far fa-clock me-1"></i> {{ $blog->reading_time }} min read</span>
                                                <span><i class="far fa-comment me-1"></i> {{ $blog->comments_count ?? 0 }} comments</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $blogs->appends(['query' => $query, 'category' => $categoryFilter])->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                                <h3>No results found</h3>
                                <p class="text-muted">We couldn't find any blog posts matching your search criteria.</p>
                                <div class="mt-4">
                                    <h5>Suggestions:</h5>
                                    <ul class="list-unstyled">
                                        <li>Check the spelling of your search term</li>
                                        <li>Try using more general keywords</li>
                                        <li>Try a different category</li>
                                        <li>Browse all blog posts instead</li>
                                    </ul>
                                </div>
                                <a href="{{ route('blogs.index') }}" class="btn btn-primary mt-3">View All Blog Posts</a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Categories Widget -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Categories</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('blogs.category', $category) }}" class="badge {{ $categoryFilter == $category ? 'bg-primary' : 'bg-light text-dark' }} text-decoration-none p-2">{{ $category }}</a>
                                @endforeach
                                <a href="{{ route('blogs.index') }}" class="badge bg-light text-dark text-decoration-none p-2">All Categories</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Write a Blog Post -->
                    <div class="card border-0 shadow-sm mb-4 bg-primary text-white">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-pencil-alt fa-3x mb-3"></i>
                            <h5 class="card-title">Share Your Experience</h5>
                            <p class="card-text">Have a travel story to share? Write a blog post and inspire other travelers!</p>
                            <a href="{{ route('blogs.create') }}" class="btn btn-light text-primary mt-2">Write a Blog Post</a>
                        </div>
                    </div>
                    
                    <!-- Popular Topics -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Popular Topics</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark p-2">Adventure</span>
                                <span class="badge bg-light text-dark p-2">Travel Tips</span>
                                <span class="badge bg-light text-dark p-2">Food</span>
                                <span class="badge bg-light text-dark p-2">Culture</span>
                                <span class="badge bg-light text-dark p-2">Photography</span>
                                <span class="badge bg-light text-dark p-2">Budget Travel</span>
                                <span class="badge bg-light text-dark p-2">Solo Travel</span>
                                <span class="badge bg-light text-dark p-2">Backpacking</span>
                                <span class="badge bg-light text-dark p-2">Luxury</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card border-0 shadow-lg rounded-lg p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <h3 class="fw-bold">Subscribe to Our Blog</h3>
                                <p class="text-muted mb-0">Get the latest travel stories, tips, and updates delivered to your inbox.</p>
                            </div>
                            <div class="col-lg-6">
                                <form>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Your email address">
                                        <button class="btn btn-primary" type="button">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection