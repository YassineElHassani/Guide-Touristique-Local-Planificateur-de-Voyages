@extends('guide.dashboard')

@section('dashboard-title', 'Create New Destination')
@section('dashboard-breadcrumb', 'Create Destination')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.destinations.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Destinations
        </a>
    </div>
@endsection

@section('dashboard-content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Destination Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('guide.destinations.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Destination Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category"
                                name="category" required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ old('category') == $category->name ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address') }}" required>
                            <div class="form-text">Start typing an address and select from the dropdown</div>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" id="coordinates" name="coordinates" value="{{ old('coordinates') }}">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Destination
                            </button>
                            <a href="{{ route('guide.destinations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
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
                        <p>To set the location: search for an address above or click directly on the map.</p>
                        <p id="selected-location">Selected location: None</p>
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
        // Default center (you can change this to be more specific to your region)
        const defaultCenter = { lat: 0, lng: 0 };
        
        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 2,
            center: defaultCenter,
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
        
        // Check if we have initial coordinates to show
        const initialCoords = document.getElementById("coordinates").value;
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
                            "Selected location: " + results[0].formatted_address;
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
            "Selected location: " + (address || "Latitude: " + lat + ", Longitude: " + lng);
    }
</script>
@endpush
