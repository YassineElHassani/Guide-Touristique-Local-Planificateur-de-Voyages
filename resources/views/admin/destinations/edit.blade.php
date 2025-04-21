@extends('admin.layout')

@section('title', 'Edit Destination')
@section('heading', 'Edit Destination')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.destinations.index') }}">Destinations</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Destination Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Destination Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $destination->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ old('category', $destination->category) == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                id="address" name="address" value="{{ old('address', $destination->address) }}" required>
                            <div class="form-text">Start typing an address and select from the dropdown</div>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description', $destination->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <input type="hidden" id="coordinates" name="coordinates" value="{{ old('coordinates', $destination->coordinates) }}">
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Destination
                            </button>
                            <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">
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
                        <p>To change the location: search for an address above or click directly on the map.</p>
                        <p id="selected-location">Current location: {{ $destination->address }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <h6>Delete Destination</h6>
                    <p class="text-muted">This will permanently delete this destination. This action cannot be undone.</p>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDestinationModal">
                        <i class="fas fa-trash"></i> Delete Destination
                    </button>
                    
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
                                    
                                    @php
                                        $reviewsCount = \App\Models\reviews::where('destination_id', $destination->id)->count();
                                    @endphp
                                    
                                    @if($reviewsCount > 0)
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            This destination has <strong>{{ $reviewsCount }}</strong> reviews.
                                            Deleting it will also delete all associated reviews.
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('NEXT_PUBLIC_GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker, geocoder, autocomplete;
    
    // Initialize the map
    function initMap() {
        // Get initial coordinates from form
        const initialCoords = document.getElementById("coordinates").value;
        let center = { lat: 0, lng: 0 };
        let initialZoom = 2;
        
        if (initialCoords) {
            const [lat, lng] = initialCoords.split(",").map(Number);
            center = { lat, lng };
            initialZoom = 15;
        }
        
        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: initialZoom,
            center: center,
        });
        
        // Create geocoder for reverse lookup
        geocoder = new google.maps.Geocoder();
        
        // Initialize autocomplete for address input
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById("address"),
            { types: ["geocode"] }
        );
        
        // Listen for place selection
        autocomplete.addListener("place_changed", function() {
            const place = autocomplete.getPlace();
            
            if (!place.geometry) {
                // User entered the name of a place that was not suggested
                return;
            }
            
            // Set the coordinates
            const location = place.geometry.location;
            setLocationOnMap(location.lat(), location.lng(), place.formatted_address);
        });
        
        // Allow clicking on the map to set location
        map.addListener("click", function(event) {
            geocoder.geocode({ location: event.latLng }, function(results, status) {
                if (status === "OK" && results[0]) {
                    document.getElementById("address").value = results[0].formatted_address;
                    setLocationOnMap(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                }
            });
        });
        
        // Set initial marker if coordinates exist
        if (initialCoords) {
            const [lat, lng] = initialCoords.split(",").map(Number);
            setLocationOnMap(lat, lng);
        }
    }
    
    // Set marker and update form
    function setLocationOnMap(lat, lng, address = null) {
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
                draggable: true
            });
            
            // Allow dragging the marker
            marker.addListener("dragend", function() {
                const position = marker.getPosition();
                geocoder.geocode({ location: position }, function(results, status) {
                    if (status === "OK" && results[0]) {
                        document.getElementById("address").value = results[0].formatted_address;
                        document.getElementById("coordinates").value = position.lat() + "," + position.lng();
                        document.getElementById("selected-location").innerHTML = 
                            "Current location: " + results[0].formatted_address;
                    }
                });
            });
        }
        
        // Update form fields
        document.getElementById("coordinates").value = lat + "," + lng;
        if (address) {
            document.getElementById("address").value = address;
        }
        
        // Update display
        document.getElementById("selected-location").innerHTML = 
            "Current location: " + (address || "Latitude: " + lat + ", Longitude: " + lng);
    }
</script>
@endpush