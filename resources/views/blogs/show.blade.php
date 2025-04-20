@extends('layouts.template')

@section('title', $blog->title)

@push('styles')
<style>
    .blog-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    
    .blog-content h2,
    .blog-content h3,
    .blog-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }
    
    .blog-content ul,
    .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    
    .blog-content blockquote {
        border-left: 4px solid var(--primary-color);
        padding-left: 1.5rem;
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 1.5rem;
        font-style: italic;
        color: var(--gray-color);
    }
    
    .comment-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }
    
    .blog-hero {
        height: 500px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .blog-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7));
    }
    
    .blog-hero-content {
        position: relative;
        z-index: 10;
        padding-top: 150px;
    }
    
    .author-badge {
        display: inline-flex;
        align-items: center;
        background-color: white;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .social-share-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .social-share-btn:hover {
        transform: translateY(-3px);
    }
    
    .facebook-btn {
        background-color: #3b5998;
    }
    
    .twitter-btn {
        background-color: #1da1f2;
    }
    
    .linkedin-btn {
        background-color: #0077b5;
    }
    
    .whatsapp-btn {
        background-color: #25d366;
    }
</style>
@endpush

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Blog Header/Hero -->
    <div class="blog-hero" style="background-image: url('{{ $blog->image ? asset('/storage/' . $blog->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1600' }}');">
        <div class="blog-hero-overlay"></div>
        <div class="container blog-hero-content">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center text-white">
                    @if($blog->category)
                        <span class="badge bg-primary mb-3">{{ $blog->category }}</span>
                    @endif
                    <h1 class="display-4 fw-bold mb-4">{{ $blog->title }}</h1>
                    <div class="author-badge mb-4">
                        <img src="{{ $blog->user->picture ?? asset('/assets/images/default-avatar.png') }}" class="rounded-circle me-2" width="36" height="36" alt="{{ $blog->user->first_name }}">
                        <div class="d-flex flex-column text-start">
                            <span class="small text-dark">{{ $blog->user->first_name }} {{ $blog->user->last_name }}</span>
                            <span class="small text-muted">{{ $blog->created_at->format('M d, Y') }} · {{ $blog->reading_time }} min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Blog Content -->
            <div class="col-lg-8 pe-lg-5">
                <!-- Blog Post Content -->
                <div class="blog-content mb-5">
                    {!! $blog->content !!}
                </div>
                
                <!-- Tags and Share -->
                <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 mb-5">
                    <div>
                        <span class="text-muted me-2">Tags:</span>
                        <span class="badge bg-light text-dark p-2">Travel</span>
                        <span class="badge bg-light text-dark p-2">Adventure</span>
                        <span class="badge bg-light text-dark p-2">{{ $blog->category }}</span>
                    </div>
                    <div class="d-flex">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="social-share-btn facebook-btn">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}" target="_blank" class="social-share-btn twitter-btn">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $blog->title }}" target="_blank" class="social-share-btn linkedin-btn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ $blog->title }} {{ url()->current() }}" target="_blank" class="social-share-btn whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Author Bio -->
                <div class="card border-0 shadow-sm mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <img src="{{ $blog->user->picture ?? asset('/assets/images/default-avatar.png') }}" class="rounded-circle me-4" width="80" height="80" alt="{{ $blog->user->first_name }}">
                            <div>
                                <h5 class="card-title">Written by {{ $blog->user->first_name }} {{ $blog->user->last_name }}</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-envelope me-1"></i> Contact
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-user me-1"></i> View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="mb-5">
                    <h3 class="mb-4">Comments ({{ count($blog->comments) }})</h3>
                    
                    @auth
                    <!-- Comment Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Leave a Comment</h5>
                            <form action="{{ route('blogs.comments.store', $blog->slug) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="4" placeholder="Write your comment here..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Comment</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Login to Comment -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Please <a href="{{ route('login') }}" class="alert-link">log in</a> to leave a comment.
                    </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div class="comments-list">
                        @forelse($blog->comments as $comment)
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <img src="{{ $comment->user->picture ?? asset('/assets/images/default-avatar.png') }}" class="comment-avatar me-3" alt="{{ $comment->user->first_name }}">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-2">{{ $comment->content }}</p>
                                            @auth
                                                @if(Auth::id() === $comment->user_id || Auth::id() === $blog->user_id)
                                                    <form action="{{ route('blogs.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Posts -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Related Posts</h5>
                        @if(count($relatedBlogs) > 0)
                            @foreach($relatedBlogs as $relatedBlog)
                                <div class="d-flex mb-3">
                                    <img src="{{ $relatedBlog->image ? asset('/storage/' . $relatedBlog->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $relatedBlog->title }}">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('blogs.show', $relatedBlog->slug) }}" class="text-decoration-none text-dark">{{ $relatedBlog->title }}</a>
                                        </h6>
                                        <small class="text-muted">{{ $relatedBlog->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No related posts found.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Latest Posts -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Latest Posts</h5>
                        @if(count($latestBlogs) > 0)
                            @foreach($latestBlogs as $latestBlog)
                                <div class="d-flex mb-3">
                                    <img src="{{ $latestBlog->image ? asset('/storage/' . $latestBlog->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $latestBlog->title }}">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('blogs.show', $latestBlog->slug) }}" class="text-decoration-none text-dark">{{ $latestBlog->title }}</a>
                                        </h6>
                                        <small class="text-muted">{{ $latestBlog->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No latest posts found.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Categories</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($blog->category ? [$blog->category] : [] as $category)
                                <a href="{{ route('blogs.category', $category) }}" class="badge bg-light text-dark text-decoration-none p-2">{{ $category }}</a>
                            @endforeach
                            <a href="{{ route('blogs.index') }}" class="badge bg-light text-dark text-decoration-none p-2">All Categories</a>
                        </div>
                    </div>
                </div>
                
                <!-- Featured Destinations -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Explore Destinations</h5>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="position-relative rounded overflow-hidden" style="height: 120px;">
                                    <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="w-100 h-100" style="object-fit: cover;" alt="Paris">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                        <h6 class="text-white mb-0">Paris</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="position-relative rounded overflow-hidden" style="height: 120px;">
                                    <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="w-100 h-100" style="object-fit: cover;" alt="Rome">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                        <h6 class="text-white mb-0">Rome</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="position-relative rounded overflow-hidden" style="height: 120px;">
                                    <img src="https://images.unsplash.com/photo-1480796927426-f609979314bd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="w-100 h-100" style="object-fit: cover;" alt="Tokyo">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                        <h6 class="text-white mb-0">Tokyo</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="position-relative rounded overflow-hidden" style="height: 120px;">
                                    <img src="https://images.unsplash.com/photo-1535139262971-c51845709a48?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="w-100 h-100" style="object-fit: cover;" alt="Bali">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                        <h6 class="text-white mb-0">Bali</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary w-100 mt-3">Explore All Destinations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection