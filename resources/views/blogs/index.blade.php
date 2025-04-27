@extends('layouts.template')

@section('title', 'Travel Blog')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fw-bold mb-3">Travel Blog & Stories</h1>
                <p class="lead mb-0">Discover travel tips, insights, and inspiring stories from our community of travelers and local guides.</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Search & Filter -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('blogs.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="search" placeholder="Search blog posts..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Featured Post -->
            @php
                $featuredBlog = \App\Models\Blog::where('featured', true)
                    ->where('published', true)
                    ->latest()
                    ->first();
            @endphp

            @if($featuredBlog && !request('search') && !request('category'))
                <div class="card border-0 shadow-sm mb-5 overflow-hidden">
                    <div class="position-relative">
                        @if($featuredBlog->image)
                            <img src="{{ asset('storage/' . $featuredBlog->image) }}" class="card-img-top" alt="{{ $featuredBlog->title }}" style="height: 400px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="fas fa-newspaper fa-4x text-secondary"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="badge bg-primary">Featured</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary">{{ $featuredBlog->category }}</span>
                            <small class="text-muted">{{ $featuredBlog->created_at->format('M d, Y') }}</small>
                        </div>
                        <h3 class="card-title mb-3">{{ $featuredBlog->title }}</h3>
                        <p class="card-text mb-4">{{ $featuredBlog->excerpt ?: Str::limit(strip_tags($featuredBlog->content), 200) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @php
                                    $author = \App\Models\User::find($featuredBlog->user_id);
                                @endphp
                                @if($author)
                                    @if($author->profile_photo_path)
                                        <img src="{{ asset('storage/' . $author->profile_photo_path) }}" alt="{{ $author->name }}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $author->name }}</p>
                                        <p class="text-muted small mb-0">{{ $featuredBlog->reading_time ?? '5' }} min read</p>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('blogs.show', $featuredBlog->id) }}" class="btn btn-outline-primary">
                                Read More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Blog Posts Grid -->
            <h2 class="fw-bold mb-4">{{ request('search') ? 'Search Results' : (request('category') ? 'Category: ' . request('category') : 'Latest Articles') }}</h2>
            
            @php
                $blogs = \App\Models\Blog::query();
                
                // Apply search filter
                if(request('search')) {
                    $search = request('search');
                    $blogs->where(function($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                              ->orWhere('content', 'like', "%{$search}%")
                              ->orWhere('category', 'like', "%{$search}%");
                    });
                }
                
                // Apply category filter
                if(request('category')) {
                    $blogs->where('category', request('category'));
                }
                
                // Only published blogs
                $blogs->where('published', true);
                
                // Exclude featured blog from regular listing if it's displayed above
                if($featuredBlog && !request('search') && !request('category')) {
                    $blogs->where('id', '!=', $featuredBlog->id);
                }
                
                $blogs = $blogs->latest()->paginate(6);
            @endphp
            
            <div class="row g-4 mb-5">
                @forelse($blogs as $blog)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-newspaper fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-secondary">{{ $blog->category }}</span>
                                    <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                </div>
                                <h5 class="card-title mb-3">{{ $blog->title }}</h5>
                                <p class="card-text mb-4">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->content), 100) }}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $blog->reading_time ?? '5' }} min read</small>
                                    <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-primary">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                        <h3>No Blog Posts Found</h3>
                        <p class="text-muted">We couldn't find any blog posts matching your criteria. Try adjusting your search or check back later.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $blogs->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Categories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Categories</h4>
                </div>
                <div class="card-body p-4">
                    @php
                        $categories = \App\Models\Blog::select('category')->distinct()->pluck('category');
                    @endphp
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <a href="{{ route('blogs.index', ['category' => $category]) }}" class="btn {{ request('category') == $category ? 'btn-primary' : 'btn-outline-primary' }} mb-2">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Popular Posts -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Popular Posts</h4>
                </div>
                <div class="card-body p-4">
                    @php
                        $popularPosts = \App\Models\Blog::where('published', true)
                            ->orderBy('views', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @forelse($popularPosts as $post)
                        <div class="d-flex mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                            <div class="flex-shrink-0">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 80px;">
                                        <i class="fas fa-newspaper fa-2x text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">{{ $post->title }}</h6>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-tag me-1"></i> {{ $post->category }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                                    <a href="{{ route('blogs.show', $post->id) }}" class="btn btn-sm btn-link p-0">Read</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">No popular posts yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Newsletter -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Subscribe to Newsletter</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Get the latest travel tips and destination guides delivered straight to your inbox.</p>
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-4">Share Your Travel Story</h2>
                <p class="lead mb-4">Have an amazing travel experience to share? Join our community of writers and inspire fellow travelers with your stories.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-user-plus me-2"></i> Join Our Community
                </a>
            </div>
        </div>
    </div>
</section>
@endsection