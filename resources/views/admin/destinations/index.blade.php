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
            <div class="d-flex">
                <form action="{{ route('admin.search') }}" method="GET" class="me-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search destinations..." name="query">
                        <input type="hidden" name="type" value="destinations">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.destinations.index') }}">All Destinations</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($categories ?? [] as $category)
                            <li><a class="dropdown-item" href="{{ route('admin.destinations.index', ['category' => $category->name]) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown ms-2">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.export', ['type' => 'destinations']) }}">Export as CSV</a></li>
                    </ul>
                </div>
            </div>
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
                            <th>Reviews</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($destinations as $destination)
                            <tr>
                                <td>{{ $destination->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($destination->image))
                                            <img src="{{ asset('storage/'.$destination->image) }}" 
                                                alt="{{ $destination->name }}" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $destination->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $destination->category }}
                                    </span>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $destination->address }}</td>
                                <td>{{ $destination->reviews->count() ?? 0 }}</td>
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
                                <td colspan="7" class="text-center py-5">
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
        @if(isset($destinations) && $destinations->count() > 0 && method_exists($destinations, 'links'))
            <div class="card-footer d-flex justify-content-center">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
@endsection