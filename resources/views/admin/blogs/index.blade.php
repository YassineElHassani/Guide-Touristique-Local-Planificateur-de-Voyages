@extends('admin.layout')

@section('title', 'Blog Management')

@section('heading', 'Blog Management')

@section('breadcrumbs')
<li class="breadcrumb-item active">Blogs</li>
@endsection

@section('actions')
<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Add New Blog
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">All Blog Posts</h5>
            <div>
                <form action="{{ route('admin.blogs.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" 
                           placeholder="Search blogs..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($blogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="100">Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>
                                    @if($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" 
                                             alt="{{ $blog->title }}" class="img-fluid rounded" 
                                             style="height: 50px; width: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                             style="height: 50px; width: 80px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.blogs.show', $blog->slug) }}" class="fw-medium text-dark">
                                        {{ Str::limit($blog->title, 40) }}
                                    </a>
                                    @if($blog->featured)
                                        <span class="badge bg-warning ms-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->user)
                                        <a href="{{ route('users.profile', $blog->user->id) }}">
                                            {{ $blog->user->first_name }} {{ $blog->user->last_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->category)
                                        <span class="badge bg-info">{{ $blog->category }}</span>
                                    @else
                                        <span class="text-muted">Uncategorized</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $blog->published ? 'bg-success' : 'bg-warning' }}">
                                        {{ $blog->published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ number_format($blog->views) }}</td>
                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.blogs.show', $blog->slug) }}" class="btn btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog->slug) }}" class="btn btn-outline-success" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-warning" title="{{ $blog->featured ? 'Remove from featured' : 'Mark as featured' }}"
                                                onclick="event.preventDefault(); document.getElementById('toggle-featured-form-{{ $blog->id }}').submit();">
                                            <i class="fas {{ $blog->featured ? 'fa-star' : 'fa-star-half-alt' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-info" title="{{ $blog->published ? 'Unpublish' : 'Publish' }}"
                                                onclick="event.preventDefault(); document.getElementById('toggle-status-form-{{ $blog->id }}').submit();">
                                            <i class="fas {{ $blog->published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" 
                                                data-bs-toggle="modal" data-bs-target="#deleteBlogModal{{ $blog->slug }}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <form id="toggle-featured-form-{{ $blog->id }}" action="{{ route('admin.blogs.toggle-featured', $blog->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                    
                                    <form id="toggle-status-form-{{ $blog->id }}" action="{{ route('admin.blogs.update-status', $blog->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="published" value="{{ $blog->published ? '0' : '1' }}">
                                    </form>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteBlogModal{{ $blog->slug }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the blog post: <strong>{{ $blog->title }}</strong>?</p>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                <h4>No Blog Posts Found</h4>
                <p class="text-muted">You haven't created any blog posts yet.</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-1"></i> Create First Blog Post
                </a>
            </div>
        @endif
    </div>
</div>
@endsection