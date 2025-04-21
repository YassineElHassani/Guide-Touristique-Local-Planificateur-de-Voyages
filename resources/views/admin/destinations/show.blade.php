@extends('admin.layout')

@section('title', 'Destination Details')
@section('heading', $destination->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.destinations.index') }}">Destinations</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $destination->name }}</li>
@endsection

@section('actions')
    <div class="btn-group">
        <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Destination
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Destination Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h2>{{ $destination->name }}</h2>
                            <p class="mb-2">
                                <span class="badge bg-primary">{{ $destination->category }}</span>
                            </p>
                            <p><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $destination->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <div id="map" style="height: 200px; width: 100%; border-radius: 5px;"></div>
                        </div>
                    </div>
                    
                    <h5 class="border-bottom pb-2 mb-3">Description</h5>
                    <p>{{ $destination->description }}</p>
                    
                    <h5 class="border-bottom pb-2 mb-3">Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">ID</th>
                                    <td>{{ $destination->id }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $destination->category }}</td>
                                </tr>
                                <tr>
                                    <th>Coordinates</th>
                                    <td>{{ $destination->coordinates }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">Created</th>
                                    <td>{{ $destination->created_at->format('M d, Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $destination->updated_at->format('M d, Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Reviews</th>
                                    <td>{{ count($reviews) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reviews</h5>
                    <span class="badge bg-primary">{{ count($reviews) }} reviews</span>
                </div>
                <div class="card-body p-0">
                    @if(count($reviews) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($reviews as $review)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0">{{ $review->user->first_name }} {{ $review->user->last_name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5>No Reviews Yet</h5>
                            <p class="text-muted">This destination hasn't received any reviews yet.</p>
                        </div>
                    @endif
                </div>
                @if(count($reviews) > 10)
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-link">View All Reviews</a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Destination
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDestinationModal">
                            <i class="fas fa-trash me-2"></i>Delete Destination
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    @php
                        $categoryObj = \App\Models\categories::where('name', $destination->category)->first();
                    @endphp
                    
                    @if($categoryObj)
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-tag fa-2x text-primary"></i>
                            </div>
                            <h5>{{ $categoryObj->name }}</h5>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Related Destinations:</strong>
                            <p class="mb-0">{{ \App\Models\destinations::where('category', $categoryObj->name)->count() }} destinations</p>
                        </div>
                        
                        <div class="d-grid">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
                                View Category
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                            <p class="mb-0">Category "{{ $destination->category }}" not found in the system.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Related Destinations</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $relatedDestinations = \App\Models\destinations::where('category', $destination->category)
                            ->where('id', '!=', $destination->id)
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($relatedDestinations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($relatedDestinations as $related)
                                <a href="{{ route('admin.destinations.show', $related->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $related->name }}</h6>
                                            <small class="text-muted">{{ Str::limit($related->address, 30) }}</small>
                                        </div>
                                        <span class="badge bg-light text-dark rounded-pill">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="mb-0">No related destinations found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Destination Modal -->
    <div class="modal fade" id="deleteDestinationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete Destination</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $destination->name }}</strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                    
                    @if(count($reviews) > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            This destination has <strong>{{ count($reviews) }}</strong> reviews.
                            Deleting it will also remove all associated reviews.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('NEXT_PUBLIC_GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const coordinates = "{{ $destination->coordinates }}".split(',');
        const lat = parseFloat(coordinates[0]);
        const lng = parseFloat(coordinates[1]);
        const location = { lat, lng };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: location,
        });
        
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ $destination->name }}"
        });
    }
</script>
@endpush