@extends('layouts.template')

@section('title', $blog->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
<style>
    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .blog-content h2, .blog-content h3 {
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .blog-content p {
        margin-bottom: 20px;
    }
    .comment-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }
    .comment-item:last-child {
        border-bottom: none;
    }
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .related-post {
        transition: transform 0.3s ease;
    }
    .related-post:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.blogs.index') }}">Blogs</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 30) }}</li>
        </ol>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Blog Article -->
            <article class="card shadow-sm mb-4">
                @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 500px; object-fit: cover;">
                @endif
                
                <div class="card-body p-4">
                    <!-- Blog Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        @if($blog->category)
                            <span class="badge bg-primary">{{ $blog->category }}</span>
                        @endif
                        
                        @if($blog->user_id === Auth::id())
                            <div class="btn-group">
                                <a href="{{ route('client.blogs.edit', $blog->slug) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBlogModal">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <button type="button" class="btn btn-outline-info" title="{{ $blog->published ? 'Unpublish' : 'Publish' }}"
                                    onclick="event.preventDefault(); document.getElementById('toggle-status-form-{{ $blog->id }}').submit();">
                                <i class="fas {{ $blog->published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                                <form id="toggle-status-form-{{ $blog->id }}" action="{{ route('client.blogs.update-status', $blog->slug) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <h1 class="card-title mb-3">{{ $blog->title }}</h1>
                    
                    <div class="d-flex align-items-center text-muted mb-4">
                        <!-- Author Info -->
                        <div class="d-flex align-items-center me-3">
                            @php
                                $authorAvatar = $blog->user && $blog->user->picture
                                    ? (Str::startsWith($blog->user->picture, 'http')
                                        ? $blog->user->picture
                                        : asset('storage/' . $blog->user->picture))
                                    : asset('/assets/images/default-avatar.png');
                            @endphp
                            <img src="{{ $authorAvatar }}" class="rounded-circle me-2" width="30" height="30" alt="Author">
                            <span>{{ $blog->user ? $blog->user->first_name . ' ' . $blog->user->last_name : 'Unknown' }}</span>
                        </div>
                        
                        <!-- Publication Date -->
                        <div class="me-3">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $blog->created_at->format('M d, Y') }}
                        </div>
                        
                        <!-- Views Count -->
                        <div>
                            <i class="far fa-eye me-1"></i>
                            {{ number_format($blog->views) }} views
                        </div>
                    </div>
                    
                    <!-- Blog Excerpt -->
                    @if($blog->excerpt)
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <p class="lead mb-0">{{ $blog->excerpt }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Blog Content -->
                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>
                    
                    <!-- Tags/Categories -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            @if($blog->category)
                                <div>
                                    <span class="me-2">Category:</span>
                                    <a href="{{ route('client.blogs.index', ['category' => $blog->category]) }}" class="badge bg-light text-dark text-decoration-none">
                                        {{ $blog->category }}
                                    </a>
                                </div>
                            @endif
                            
                            <!-- Social Share -->
                            <div class="d-flex gap-2">
                                <span class="text-muted me-2">Share:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('client.blogs.show', $blog->slug)) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('client.blogs.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('{{ route('client.blogs.show', $blog->slug) }}')">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            
            <!-- Comments Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Comments ({{ $blog->comments->count() }})</h4>
                </div>
                <div class="card-body">
                    <!-- Comment Form -->
                    <form action="{{ route('blogs.comments.store', $blog->slug) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Leave a comment</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <!-- Comments List -->
                    @if($blog->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($blog->comments as $comment)
                                <div class="comment-item">
                                    <div class="d-flex">
                                        <!-- Commenter Avatar -->
                                        <div class="flex-shrink-0 me-3">
                                            @php
                                                $commentAvatar = $comment->user && $comment->user->picture
                                                    ? (Str::startsWith($comment->user->picture, 'http')
                                                        ? $comment->user->picture
                                                        : asset('storage/' . $comment->user->picture))
                                                    : asset('/assets/images/default-avatar.png');
                                            @endphp
                                            <img src="{{ $commentAvatar }}" class="user-avatar" alt="User">
                                        </div>
                                        
                                        <!-- Comment Content -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <h5 class="mb-0">{{ $comment->user ? $comment->user->first_name . ' ' . $comment->user->last_name : 'Anonymous' }}</h5>
                                                    <small class="text-muted">{{ $comment->created_at->format('M d, Y \a\t H:i') }}</small>
                                                </div>
                                                
                                                <!-- Comment Actions -->
                                                @if(Auth::id() === $comment->user_id)
                                                    <form action="{{ route('blogs.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No comments yet. Be the first to comment!</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Related Posts -->
            @if($relatedBlogs->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Related Posts</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedBlogs as $relatedBlog)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border-0 shadow-sm related-post">
                                        @if($relatedBlog->image)
                                            <img src="{{ asset('storage/' . $relatedBlog->image) }}" class="card-img-top" alt="{{ $relatedBlog->title }}" style="height: 160px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                                <i class="fas fa-image text-muted fa-2x"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('client.blogs.show', $relatedBlog->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($relatedBlog->title, 40) }}
                                                </a>
                                            </h5>
                                            <p class="card-text small text-muted">
                                                {{ Str::limit($relatedBlog->excerpt ?? strip_tags($relatedBlog->content), 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Author Card -->
            @if($blog->user)
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <img src="{{ $authorAvatar }}" class="rounded-circle mb-3" width="100" height="100" alt="Author">
                        <h5>{{ $blog->user->first_name }} {{ $blog->user->last_name }}</h5>
                        <p class="text-muted mb-3">{{ $blog->user->role }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-envelope me-1"></i> Contact
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-book me-1"></i> All Posts
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Blog Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Blog Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Published on</span>
                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Status</span>
                            <span class="badge bg-{{ $blog->published ? 'success' : 'warning' }}">
                                {{ $blog->published ? 'Published' : 'Draft' }}
                            </span>
                        </li>
                        @if($blog->category)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Category</span>
                                <span>{{ $blog->category }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Views</span>
                            <span>{{ number_format($blog->views) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Comments</span>
                            <span>{{ $blog->comments->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Latest Posts -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Latest Posts</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($latestBlogs as $latestBlog)
                            <li class="list-group-item">
                                <div class="row g-0">
                                    <div class="col-3">
                                        @if($latestBlog->image)
                                            <img src="{{ asset('storage/' . $latestBlog->image) }}" class="img-fluid rounded" alt="{{ $latestBlog->title }}" style="height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 100%;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-9 ps-3">
                                        <a href="{{ route('client.blogs.show', $latestBlog->slug) }}" class="text-decoration-none">
                                            <h6 class="mb-1 text-dark">{{ Str::limit($latestBlog->title, 40) }}</h6>
                                        </a>
                                        <small class="text-muted">{{ $latestBlog->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('client.blogs.index') }}" class="btn btn-sm btn-outline-primary">View All Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Blog Modal -->
@if(Auth::id() === $blog->user_id)
    <div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Blog Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this blog post?</p>
                    <p class="text-danger">This action cannot be undone and will also delete all associated comments.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('client.blogs.destroy', $blog->slug) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link copied to clipboard!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush