@extends('admin.layout')

@section('title', 'Edit Event')
@section('heading', 'Edit Event')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Event Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $event->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Event Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                id="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                                <option value="">Select a location</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->name }}" 
                                        {{ old('location', $event->location) == $destination->name ? 'selected' : '' }}
                                        data-coordinates="{{ $destination->coordinates }}">
                                        {{ $destination->name }} - {{ $destination->address }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                id="price" name="price" value="{{ old('price', $event->price) }}" step="0.01" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Event Image</label>
                            @if($event->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            <div class="form-text">Upload a new image to replace the existing one. Leave empty to keep the current image.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Location on Map</h5>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                    <div class="mt-2 text-muted small">
                        <p>Select a location from the dropdown to update the map.</p>
                        <p id="selected-location">Current location: {{ $event->location }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <h6>Delete Event</h6>
                    <p class="text-muted">This will permanently delete this event. This action cannot be undone.</p>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal">
                        <i class="fas fa-trash"></i> Delete Event
                    </button>
                    
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('NEXT_PUBLIC_GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script>
    let map, marker;
    
    // Initialize the map
    function initMap() {
        // Default center
        let center = { lat: 0, lng: 0 };
        let initialZoom = 2;
        
        // Try to get coordinates for the current location
        const locationSelect = document.getElementById('location');
        const selectedOption = locationSelect.options[locationSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const coordinatesString = selectedOption.getAttribute('data-coordinates');
            
            if (coordinatesString) {
                const [lat, lng] = coordinatesString.split(',').map(Number);
                center = { lat, lng };
                initialZoom = 15;
            }
        }
        
        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: initialZoom,
            center: center,
        });
        
        // If we have coordinates, set the marker
        if (initialZoom === 15) {
            marker = new google.maps.Marker({
                position: center,
                map: map,
                title: selectedOption.text
            });
        }
        
        // Listen for changes to the location select
        locationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const coordinatesString = selectedOption.getAttribute('data-coordinates');
                
                if (coordinatesString) {
                    const [lat, lng] = coordinatesString.split(',').map(Number);
                    setLocationOnMap(lat, lng, selectedOption.text);
                }
            } else {
                // Reset map if no location is selected
                if (marker) {
                    marker.setMap(null);
                    marker = null;
                }
                map.setCenter({ lat: 0, lng: 0 });
                map.setZoom(2);
                document.getElementById("selected-location").innerHTML = "Current location: None";
            }
        });
    }
    
    // Set marker on the map
    function setLocationOnMap(lat, lng, locationName) {
        // Update map center
        const latLng = new google.maps.LatLng(lat, lng);
        map.setCenter(latLng);
        map.setZoom(15);
        
        // Create or move the marker
        if (marker) {
            marker.setPosition(latLng);
        } else {
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: locationName
            });
        }
        
        // Update display
        document.getElementById("selected-location").innerHTML = "Current location: " + locationName;
    }
</script>
@endpush