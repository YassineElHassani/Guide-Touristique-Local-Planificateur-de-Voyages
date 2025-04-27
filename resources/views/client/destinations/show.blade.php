@extends('client.dashboard')

@section('dashboard-title', $destination->name)
@section('dashboard-breadcrumb', 'Destination Details')

@section('dashboard-content')
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    @php
                        $categoryObj = \App\Models\categories::where('name', $destination->category)->first();
                    @endphp

                    @if ($categoryObj)
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-2"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-tag fa-2x text-primary"></i>
                            </div>
                            <h5>{{ $categoryObj->name }}</h5>
                        </div>

                        <div class="mb-2">
                            <strong>Related Destinations:</strong>
                            <p class="mb-0">
                                {{ \App\Models\destinations::where('category', $categoryObj->name)->count() }} destinations
                            </p>
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

                    @if ($relatedDestinations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($relatedDestinations as $related)
                                <a href="{{ route('client.destinations.show', $related->id) }}"
                                    class="list-group-item list-group-item-action">
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

@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('NEXT_PUBLIC_GOOGLE_MAPS_API_KEY') }}&callback=initMap"
        async defer></script>
    <script>
        function initMap() {
            const coordinates = "{{ $destination->coordinates }}".split(',');
            const lat = parseFloat(coordinates[0]);
            const lng = parseFloat(coordinates[1]);
            const location = {
                lat,
                lng
            };

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
