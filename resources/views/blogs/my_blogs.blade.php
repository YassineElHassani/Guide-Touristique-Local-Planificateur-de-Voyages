@extends('layouts.template')

@section('title', 'My Blog Posts')

@section('content')
    <!-- Header Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-3">My Blog Posts</h1>
                    <p>Manage your travel stories, guides, and experiences.</p>
                </div>
            </div>
        </div>
    </section>
    
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Your Blog Posts</h2>
                <p class="text-muted">You have {{ count($blogs) }} blog post(s)</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Write New Blog Post
                </a>
            </div>
        </div>
        
        <!-- Blog Posts Table -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-0">
                @if(count($blogs) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Published</th>
                                    <th>Views</th>
                                    <th>Comments</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $blog->title }}">
                                                <div>
                                                    <div class="fw-bold text-truncate" style="max-width: 250px;">{{ $blog->title }}</div>
                                                    <div class="small text-truncate text-muted" style="max-width: 250px;">{{ $blog->excerpt }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($blog->published)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                            
                                            @if($blog->featured)
                                                <span class="badge bg-primary">Featured</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->category ?? 'Uncategorized' }}</td>
                                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                        <td><i class="fas fa-eye me-1 text-muted"></i> {{ $blog->views }}</td>
                                        <td><i class="fas fa-comment me-1 text-muted"></i> {{ $blog->comments_count }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('blogs.edit', $blog->slug) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBlogModal{{ $blog->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteBlogModal{{ $blog->id }}" tabindex="-1" aria-labelledby="deleteBlogModalLabel{{ $blog->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteBlogModalLabel{{ $blog->id }}">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete the blog post "{{ $blog->title }}"?</p>
                                                            <p class="text-danger">This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('blogs.destroy', $blog->slug) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete Blog Post</button>
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
                @else
                    <div class="text-center py-5">
                        <div class="py-5">
                            <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                            <h3>No blog posts yet</h3>
                            <p class="text-muted mb-4">You haven't created any blog posts yet. Start sharing your travel experiences!</p>
                            <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Write Your First Blog Post
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Pagination -->
        @if(count($blogs) > 0)
            <div class="d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>
        @endif
        
        <!-- Blog Post Tips Section -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Tips for Engaging Blog Posts</h3>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                        <i class="fas fa-book-reader fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5>Know Your Audience</h5>
                                        <p class="text-muted">Understand who you're writing for and what information would be most valuable to them.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                        <i class="fas fa-camera fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5>Use High-Quality Images</h5>
                                        <p class="text-muted">Incorporate your own photos to showcase your experiences and make your blog visually appealing.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                        <i class="fas fa-search fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5>Provide Unique Insights</h5>
                                        <p class="text-muted">Share personal experiences and insights that readers won't find in guidebooks or other blogs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection