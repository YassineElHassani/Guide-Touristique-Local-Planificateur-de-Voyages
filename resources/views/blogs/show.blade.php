@extends('layouts.template')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Blog Post -->
            <div class="card border-0 shadow-sm mb-4">
                @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://images.unsplash.com/photo-1500835556837-99ac94a94552?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                
                <div class="card-body p-4 p-lg-5">
                    @if($blog->category)
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $blog->category }}</span>
                            @if($blog->featured)
                                <span class="badge bg-warning ms-2">Featured</span>
                            @endif
                        </div>
                    @endif
                    
                    <h1 class="card-title mb-3">{{ $blog->title }}</h1>
                    
                    <div class="d-flex align-items-center mb-4">
                        @php
                            $avatar = $blog->user->picture
                                ? (Str::startsWith($blog->user->picture, 'http')
                                    ? $blog->user->picture
                                    : asset('storage/' . $blog->user->picture))
                                : asset('/assets/images/default-avatar.png');
                        @endphp
                        <img src="{{ $avatar }}" class="rounded-circle" width="48" height="48" alt="{{ $blog->user->first_name }}">
                        <div class="ms-3">
                            <h6 class="mb-0">{{ $blog->user->first_name }} {{ $blog->user->last_name }}</h6>
                            <div class="small text-muted">
                                <span><i class="far fa-calendar-alt me-1"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span><i class="far fa-clock me-1"></i>{{ $blog->reading_time ?? '5' }} min read</span>
                                <span class="mx-2">•</span>
                                <span><i class="far fa-eye me-1"></i>{{ $blog->views ?? '0' }} views</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="blog-content mb-4">
                        {!! $blog->content !!}
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 my-4">
                        <div>
                            <span class="me-2">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.show', $blog->slug)) }}" class="text-primary me-2" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blogs.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" class="text-info me-2" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blogs.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}" class="text-primary" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <div>
                            <span><i class="far fa-comment me-1"></i>{{ $blog->comments->count() }} Comments</span>
                        </div>
                    </div>
                    
                    <!-- Author Bio -->
                    <div class="bg-light p-4 rounded-3 mb-4">
                        <div class="d-flex">
                            <img src="{{ $avatar }}" class="rounded-circle" width="64" height="64" alt="{{ $blog->user->first_name }}">
                            <div class="ms-3">
                                <h5>About the Author</h5>
                                <p>{{ $blog->user->bio ?? 'Travel enthusiast and writer sharing experiences from around the world.' }}</p>
                                @if($blog->user->social_media)
                                    <div class="social-links">
                                        @if(isset($blog->user->social_media['twitter']))
                                            <a href="{{ $blog->user->social_media['twitter'] }}" class="text-info me-2" target="_blank"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if(isset($blog->user->social_media['instagram']))
                                            <a href="{{ $blog->user->social_media['instagram'] }}" class="text-danger me-2" target="_blank"><i class="fab fa-instagram"></i></a>
                                        @endif
                                        @if(isset($blog->user->social_media['linkedin']))
                                            <a href="{{ $blog->user->social_media['linkedin'] }}" class="text-primary" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments Section -->
                    <div id="comments" class="mt-5">
                        <h3 class="mb-4">Comments ({{ $blog->comments->count() }})</h3>
                        
                        @if($blog->comments->count() > 0)
                            <div class="comments-list">
                                @foreach($blog->comments as $comment)
                                    <div class="comment-item bg-light p-3 rounded mb-3">
                                        <div class="d-flex">
                                            @php
                                                $commentAvatar = $comment->user && $comment->user->picture
                                                    ? (Str::startsWith($comment->user->picture, 'http')
                                                        ? $comment->user->picture
                                                        : asset('storage/' . $comment->user->picture))
                                                    : asset('/assets/images/default-avatar.png');
                                            @endphp
                                            <img src="{{ $commentAvatar }}" class="rounded-circle" width="48" height="48" alt="{{ $comment->user->first_name ?? 'User' }}">
                                            <div class="ms-3 flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $comment->user->first_name ?? 'Anonymous' }} {{ $comment->user->last_name ?? '' }}</h6>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mt-2 mb-0">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-light">
                                <p class="mb-0">No comments yet. Be the first to share your thoughts!</p>
                            </div>
                        @endif
                        
                        <!-- Comment Form -->
                        <div class="comment-form mt-4">
                            <h4 class="mb-3">Leave a Comment</h4>
                            @auth
                                <form action="{{ route('blogs.comments.store', $blog->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="content" rows="4" placeholder="Share your thoughts about this post..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    Please <a href="{{ route('login') }}">login</a> to leave a comment.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Author Widget -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <img src="{{ $avatar }}" class="rounded-circle mb-3" width="80" height="80" alt="{{ $blog->user->first_name }}">
                    <h5>{{ $blog->user->first_name }} {{ $blog->user->last_name }}</h5>
                    <p class="text-muted">{{ $blog->user->bio ?? 'Travel writer and explorer' }}</p>
                </div>
            </div>
            
            <!-- Related Posts -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Related Posts</h5>
                </div>
                <div class="card-body">
                    @if($relatedBlogs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($relatedBlogs as $relatedBlog)
                                <a href="{{ route('blogs.show', $relatedBlog->slug) }}" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex">
                                        @if($relatedBlog->image)
                                            <img src="{{ asset('storage/' . $relatedBlog->image) }}" class="rounded" width="60" height="60" style="object-fit: cover;" alt="{{ $relatedBlog->title }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="ms-3">
                                            <h6 class="mb-1">{{ Str::limit($relatedBlog->title, 40) }}</h6>
                                            <small class="text-muted">{{ $relatedBlog->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No related posts found.</p>
                    @endif
                </div>
            </div>
            
            <!-- Latest Posts -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Latest Posts</h5>
                </div>
                <div class="card-body">
                    @if($latestBlogs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestBlogs as $latestBlog)
                                <a href="{{ route('blogs.show', $latestBlog->slug) }}" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex">
                                        @if($latestBlog->image)
                                            <img src="{{ asset('storage/' . $latestBlog->image) }}" class="rounded" width="60" height="60" style="object-fit: cover;" alt="{{ $latestBlog->title }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="ms-3">
                                            <h6 class="mb-1">{{ Str::limit($latestBlog->title, 40) }}</h6>
                                            <small class="text-muted">{{ $latestBlog->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No latest posts found.</p>
                    @endif
                </div>
            </div>
            
            <!-- Categories Widget -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    @php
                        $categories = \App\Models\Blog::select('category')
                            ->distinct()
                            ->whereNotNull('category')
                            ->get()
                            ->pluck('category');
                    @endphp
                    
                    @if($categories->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categories as $category)
                                <p class="btn-outline-primary btn-sm mb-2">{{ $category }}</p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No categories found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add syntax highlighting if code blocks exist
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there are code blocks that need highlighting
        const codeBlocks = document.querySelectorAll('pre code');
        if (codeBlocks.length > 0) {
            // Load highlight.js if needed
            const highlightScript = document.createElement('script');
            highlightScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js';
            document.head.appendChild(highlightScript);
            
            const highlightCss = document.createElement('link');
            highlightCss.rel = 'stylesheet';
            highlightCss.href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/github.min.css';
            document.head.appendChild(highlightCss);
            
            highlightScript.onload = function() {
                hljs.highlightAll();
            };
        }
    });
</script>
@endsection