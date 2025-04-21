@extends('admin.layout')

@section('title', 'Category Details')
@section('heading', 'Category Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
@endsection

@section('actions')
    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit Category
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                        <h3>{{ $category->name }}</h3>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Category ID
                            <span class="badge bg-secondary rounded-pill">{{ $category->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Destinations
                            <span class="badge bg-primary rounded-pill">{{ $destinations->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Created
                            <span>{{ $category->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Last Updated
                            <span>{{ $category->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            
            <!-- Delete Category Modal -->
            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Delete Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the <strong>{{ $category->name }}</strong> category?</p>
                            <p class="text-danger">This action cannot be undone. Content using this category may be affected.</p>
                            
                            @if($destinations->count() > 0)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    This category is currently used by <strong>{{ $destinations->count() }}</strong> destinations.
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Permanently</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Destinations in this Category</h5>
                    <span class="badge bg-primary">{{ $destinations->count() }} destinations</span>
                </div>
                <div class="card-body p-0">
                    @if($destinations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($destinations as $destination)
                                        <tr>
                                            <td>{{ $destination->id }}</td>
                                            <td>{{ $destination->name }}</td>
                                            <td>{{ $destination->address }}</td>
                                            <td>{{ $destination->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.destinations.show', $destination->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                            <h5>No Destinations Found</h5>
                            <p class="text-muted">There are no destinations using this category yet.</p>
                            <a href="{{ route('admin.destinations.create') }}" class="btn btn-outline-primary mt-2">
                                <i class="fas fa-plus"></i> Add Destination
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection