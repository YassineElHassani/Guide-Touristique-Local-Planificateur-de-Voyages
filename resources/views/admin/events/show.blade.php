@extends('admin.layout')

@section('title', 'Event Details')
@section('heading', $event->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $event->name }}</li>
@endsection

@section('actions')
    <div class="btn-group">
        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Event
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Event Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h2>{{ $event->name }}</h2>
                            <p class="mb-2">
                                <span class="badge bg-primary">${{ number_format($event->price, 2) }}</span>
                                <span class="badge bg-secondary">{{ $event->date->format('F d, Y') }}</span>
                            </p>
                            <p><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $event->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <div id="map" style="height: 200px; width: 100%; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            @if($event->image)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="img-fluid rounded">
                                </div>
                            @else
                                <p class="text-muted">No image available for this event.</p>
                            @endif
                        </div>

                    </div>
                    
                    <h5 class="border-bottom pb-2 mb-3">Description</h5>
                    <p>{{ $event->description }}</p>
                    
                    <h5 class="border-bottom pb-2 mb-3">Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">ID</th>
                                    <td>{{ $event->id }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $event->date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>${{ number_format($event->price, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">Created</th>
                                    <td>{{ $event->created_at->format('M d, Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $event->updated_at->format('M d, Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Reservations</th>
                                    <td>
                                        @php
                                            $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->count();
                                        @endphp
                                        {{ $reservationsCount }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reservations</h5>
                    <span class="badge bg-primary">
                        @php
                            $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->count();
                        @endphp
                        {{ $reservationsCount }} reservations
                    </span>
                </div>
                <div class="card-body p-0">
                    @php
                        $reservations = \App\Models\reservations::where('event_id', $event->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp
                    
                    @if(count($reservations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>
                                                @if($reservation->user)
                                                    {{ $reservation->user->first_name }} {{ $reservation->user->last_name }}
                                                @else
                                                    Unknown User
                                                @endif
                                            </td>
                                            <td>{{ $reservation->date->format('M d, Y') }}</td>
                                            <td>
                                                @if($reservation->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($reservation->status == 'confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $reservation->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                            <h5>No Reservations Yet</h5>
                            <p class="text-muted">This event hasn't received any reservations yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Event
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal">
                            <i class="fas fa-trash me-2"></i>Delete Event
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Location Information</h5>
                </div>
                <div class="card-body">
                    @php
                        $destination = \App\Models\destinations::where('name', $event->location)->first();
                    @endphp
                    
                    @if($destination)
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <h5>{{ $destination->name }}</h5>
                            <p class="text-muted mb-0">{{ $destination->address }}</p>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Category:</strong>
                            <p class="mb-0">{{ $destination->category }}</p>
                        </div>
                        
                        <div class="d-grid">
                            <a href="{{ route('admin.destinations.show', $destination->id) }}" class="btn btn-outline-secondary btn-sm">
                                View Destination
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                            <p class="mb-0">Location "{{ $event->location }}" not found in destinations.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Related Events</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $relatedEvents = \App\Models\events::where('location', $event->location)
                            ->where('id', '!=', $event->id)
                            ->orderBy('date', 'asc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($relatedEvents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($relatedEvents as $related)
                                <a href="{{ route('admin.events.show', $related->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $related->name }}</h6>
                                            <small class="text-muted">{{ $related->date->format('M d, Y') }}</small>
                                        </div>
                                        <span class="badge bg-primary">${{ number_format($related->price, 2) }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="mb-0">No related events found at this location.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Event Modal -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $event->name }}</strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                    
                    @php
                        $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->count();
                    @endphp
                    
                    @if($reservationsCount > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            This event has <strong>{{ $reservationsCount }}</strong> active reservations.
                            All reservations must be canceled before deleting.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ $reservationsCount > 0 ? 'disabled' : '' }}>
                            Delete Permanently
                        </button>
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
        @php
            $destination = \App\Models\destinations::where('name', $event->location)->first();
            $coordinates = $destination ? $destination->coordinates : '0,0';
        @endphp
        
        const coordinates = "{{ $coordinates }}".split(',');
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
            title: "{{ $event->location }}"
        });
    }
</script>
@endpush