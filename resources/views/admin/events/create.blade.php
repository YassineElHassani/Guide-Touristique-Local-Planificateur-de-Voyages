@extends('admin.layout')

@section('title', 'Create Event')
@section('heading', 'Create Event')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Event Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Event Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                                <option value="">Select a location</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->name }}" {{ old('location') == $destination->name ? 'selected' : '' }}
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
                                id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Event Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            <div class="form-text">Upload an image for this event. Maximum size: 2MB.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
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
                        <p>Select a location from the dropdown to see it on the map.</p>
                        <p id="selected-location">Selected location: None</p>
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
        // Default center (you can change this to be more specific to your region)
        const defaultCenter = { lat: 0, lng: 0 };
        
        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 2,
            center: defaultCenter,
        });
        
        // Listen for changes to the location select
        document.getElementById('location').addEventListener('change', function() {
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
                map.setCenter(defaultCenter);
                map.setZoom(2);
                document.getElementById("selected-location").innerHTML = "Selected location: None";
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
        document.getElementById("selected-location").innerHTML = "Selected location: " + locationName;
    }
</script>
@endpush