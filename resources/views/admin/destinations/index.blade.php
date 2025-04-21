@extends('admin.layout')

@section('title', 'Destination Management')
@section('heading', 'Destination Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Destinations</li>
@endsection

@section('actions')
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Destination
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Destinations</h5>
            <form action="{{ route('admin.search') }}" method="GET" class="me-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search destinations..." name="query">
                    <input type="hidden" name="type" value="destinations">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Address</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($destinations as $destination)
                            <tr>
                                <td>{{ $destination->id }}</td>
                                <td>{{ $destination->name }}</td>
                                <td>{{ $destination->category }}</td>
                                <td>{{ $destination->address }}</td>
                                <td>{{ $destination->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.destinations.show', $destination->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $destination->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $destination->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the destination <strong>{{ $destination->name }}</strong>?</p>
                                                    <p class="text-danger">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Destination</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                        <h5>No Destinations Found</h5>
                                        <p class="text-muted">There are no destinations in the system yet.</p>
                                        <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Add Destination
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($destinations) && method_exists($destinations, 'links'))
            <div class="card-footer d-flex justify-content-center">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
@endsection