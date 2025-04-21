@extends('admin.layout')

@section('title', $blog->title)

@section('heading', 'Blog Details')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
<li class="breadcrumb-item active">View</li>
@endsection

@section('actions')
<div class="btn-group">
    <a href="{{ route('admin.blogs.edit', $blog->slug) }}" class="btn btn-primary">
        <i class="fas fa-edit me-1"></i> Edit
    </a>
    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="btn btn-info">
        <i class="fas fa-external-link-alt me-1"></i> View on Site
    </a>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBlogModal">
        <i class="fas fa-trash me-1"></i> Delete
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Blog Content -->
        <div class="card mb-4">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" 
                     class="card-img-top" style="max-height: 400px; object-fit: cover;">
            @endif
            
            <div class="card-body">
                <h1 class="card-title">{{ $blog->title }}</h1>
                
                <div class="d-flex align-items-center text-muted mb-4">
                    <div class="me-3">
                        <i class="fas fa-user me-1"></i>
                        @if($blog->user)
                            <a href="{{ route('users.profile', $blog->user->id) }}">
                                {{ $blog->user->first_name }} {{ $blog->user->last_name }}
                            </a>
                        @else
                            Unknown
                        @endif
                    </div>
                    <div class="me-3">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $blog->created_at->format('M d, Y') }}
                    </div>
                    @if($blog->category)
                        <div class="me-3">
                            <i class="fas fa-folder me-1"></i>
                            {{ $blog->category }}
                        </div>
                    @endif
                    <div>
                        <i class="fas fa-eye me-1"></i>
                        {{ number_format($blog->views) }} views
                    </div>
                </div>
                
                @if($blog->excerpt)
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Excerpt</h6>
                            <p class="card-text">{{ $blog->excerpt }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="blog-content">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>
        
        <!-- Comments Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Comments ({{ $blog->comments->count() }})</h5>
                <a href="{{ route('admin.comments.index') }}?blog_id={{ $blog->id }}" class="btn btn-sm btn-outline-secondary">
                    Manage Comments
                </a>
            </div>
            <div class="card-body">
                @if($blog->comments->count() > 0)
                    @foreach($blog->comments as $comment)
                        <div class="d-flex mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0 me-3">
                                @if($comment->user && $comment->user->picture)
                                    <img src="{{ asset('storage/' . $comment->user->picture) }}" 
                                         alt="{{ $comment->user->first_name }}" 
                                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; font-size: 1.5rem;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <strong>
                                            @if($comment->user)
                                                {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                            @else
                                                Anonymous
                                            @endif
                                        </strong>
                                        <span class="text-muted ms-2">
                                            {{ $comment->created_at->format('M d, Y \a\t H:i') }}
                                        </span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteCommentModal{{ $comment->id }}">
                                                    <i class="fas fa-trash me-1 text-danger"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                        
                        <!-- Delete Comment Modal -->
                        <div class="modal fade" id="deleteCommentModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Comment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this comment?</p>
                                        <p class="text-muted">{{ Str::limit($comment->content, 100) }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted my-4">No comments yet</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Blog Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Status</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Published</span>
                    <form action="{{ route('admin.blogs.update-status', $blog->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <div class="form-check form-switch">
                            <input type="hidden" name="published" value="0">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="publishedSwitch" {{ $blog->published ? 'checked' : '' }}
                                   onchange="this.form.published.value=this.checked ? '1' : '0'; this.form.submit();">
                        </div>
                    </form>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span>Featured</span>
                    <form action="{{ route('admin.blogs.toggle-featured', $blog->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="featuredSwitch" {{ $blog->featured ? 'checked' : '' }}
                                   onchange="this.form.submit();">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Blog Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Blog Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="120"><strong>Author</strong></td>
                        <td>
                            @if($blog->user)
                                <a href="{{ route('users.profile', $blog->user->id) }}">
                                    {{ $blog->user->first_name }} {{ $blog->user->last_name }}
                                </a>
                            @else
                                Unknown
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Created</strong></td>
                        <td>{{ $blog->created_at->format('M d, Y \a\t H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated</strong></td>
                        <td>{{ $blog->updated_at->format('M d, Y \a\t H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge {{ $blog->published ? 'bg-success' : 'bg-warning' }}">
                                {{ $blog->published ? 'Published' : 'Draft' }}
                            </span>
                            @if($blog->featured)
                                <span class="badge bg-warning ms-1">Featured</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Category</strong></td>
                        <td>{{ $blog->category ?? 'Uncategorized' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Views</strong></td>
                        <td>{{ number_format($blog->views) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Comments</strong></td>
                        <td>{{ $blog->comments->count() }}</td>
                    </tr>
                    <tr>
                        <td><strong>Slug</strong></td>
                        <td><code>{{ $blog->slug }}</code></td>
                    </tr>
                </table>
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
                <form action="{{ route('admin.blogs.destroy', $blog->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection