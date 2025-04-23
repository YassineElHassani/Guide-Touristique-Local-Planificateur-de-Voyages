@extends('client.dashboard')

@section('title', $itinerary->name)
@section('dashboard-title', $itinerary->name)
@section('dashboard-breadcrumb', 'Itinerary Details')

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 3rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 14px;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: var(--light-gray);
    }
    
    .timeline-day {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .timeline-day::before {
        content: '';
        position: absolute;
        left: -3rem;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid var(--primary-color);
        z-index: 1;
    }
    
    .timeline-day::after {
        content: attr(data-day);
        position: absolute;
        left: -3rem;
        top: 6px;
        width: 30px;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        color: var(--primary-color);
    }
    
    .timeline-item {
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid var(--light-gray);
        margin-bottom: 1rem;
        position: relative;
        background-color: white;
        transition: all 0.3s ease;
    }
    
    .timeline-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }
    
    .destination-img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    
    .weather-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        border-radius: 1rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        background-color: rgba(255, 255, 255, 0.9);
    }
</style>
@endpush

@section('dashboard-actions')
<div class="d-flex gap-2">
    <a href="{{ route('client.itineraries.edit', $itinerary->id) }}" class="btn btn-outline-primary">
        <i class="fas fa-edit me-1"></i> Edit
    </a>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="shareDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-share-alt me-1"></i> Share
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="shareDropdown">
            <li><a class="dropdown-item" href="{{ route('client.itineraries.share', $itinerary->id) }}"><i class="fas fa-link me-2"></i> Get Link</a></li>
            <li><a class="dropdown-item" href="{{ route('client.itineraries.generate-pdf', $itinerary->id) }}"><i class="fas fa-file-pdf me-2"></i> Export as PDF</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Email</a></li>
        </ul>
    </div>
</div>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Itinerary Info Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3 mb-md-0">
                    <h5 class="card-title">Trip Details</h5>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div>
                            <p class="text-muted mb-1">Start Date</p>
                            <p class="fw-bold mb-0">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($itinerary->start_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-muted mb-1">End Date</p>
                            <p class="fw-bold mb-0">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($itinerary->end_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Duration</p>
                            <p class="fw-bold mb-0">
                                <i class="fas fa-clock text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($itinerary->start_date)->diffInDays($itinerary->end_date) + 1 }} days
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-map-marked-alt me-1"></i> View Map
                    </button>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-calendar-plus me-1"></i> Add to Calendar
                    </button>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Itinerary Timeline -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Itinerary Timeline</h5>
                <div>
                    <select class="form-select form-select-sm" id="viewMode">
                        <option value="day">View by Day</option>
                        <option value="destination">View by Destination</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    @foreach($destinationsByDay as $day => $dayDestinations)
                        <div class="timeline-day" data-day="{{ $day }}">
                            <h5 class="mb-3">Day {{ $day }} - {{ \Carbon\Carbon::parse($itinerary->start_date)->addDays($day - 1)->format('D, M d') }}</h5>
                            
                            @foreach($dayDestinations as $destination)
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-md-3 mb-3 mb-md-0">
                                            <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" alt="{{ $destination->name }}" class="destination-img">
                                            <div class="weather-badge">
                                                <i class="fas fa-sun text-warning"></i> 26°C
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="mb-0">{{ $destination->name }}</h6>
                                                <span class="badge bg-primary">{{ $destination->pivot->order }}</span>
                                            </div>
                                            <p class="text-muted small mb-2">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $destination->address }}
                                            </p>
                                            <p class="small mb-0">{{ Str::limit($destination->description, 150) }}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <a href="{{ route('destinations.show', $destination->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                                <div>
                                                    <button class="btn btn-sm btn-outline-secondary me-1">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-primary btn-sm mb-3">
                                    <i class="fas fa-plus me-1"></i> Add Destination to Day {{ $day }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Sidebar -->
    <div class="col-lg-4">
        <!-- Trip Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Trip Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Days</span>
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($itinerary->start_date)->diffInDays($itinerary->end_date) + 1 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Destinations</span>
                        <span class="fw-bold">{{ count($itinerary->destinations) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Estimated Budget</span>
                        <span class="fw-bold text-primary">$1,250</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <h6 class="mb-2">Destinations by Category</h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Landmarks</small>
                            <small>4</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Museums</small>
                            <small>3</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Nature</small>
                            <small>2</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Food & Dining</small>
                            <small>1</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Weather Forecast -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Weather Forecast</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @for($i = 0; $i < min(5, \Carbon\Carbon::parse($itinerary->start_date)->diffInDays($itinerary->end_date) + 1); $i++)
                        <div class="col">
                            <div class="text-center p-2 rounded bg-light">
                                <p class="small mb-1">{{ \Carbon\Carbon::parse($itinerary->start_date)->addDays($i)->format('D') }}</p>
                                <i class="fas fa-{{ ['sun', 'cloud-sun', 'cloud', 'cloud-sun-rain', 'sun'][rand(0, 4)] }} {{ $i % 2 == 0 ? 'text-warning' : 'text-secondary' }}"></i>
                                <p class="mb-0">{{ 20 + rand(-5, 10) }}°C</p>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Data from Weather Service</small>
                </div>
            </div>
        </div>
        
        <!-- Packing List -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Packing List</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="packingItem1" checked>
                        <label class="form-check-label" for="packingItem1">Passport & Travel Documents</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="packingItem2">
                        <label class="form-check-label" for="packingItem2">Clothing for {{ \Carbon\Carbon::parse($itinerary->start_date)->diffInDays($itinerary->end_date) + 1 }} days</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="packingItem3">
                        <label class="form-check-label" for="packingItem3">Toiletries</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="packingItem4">
                        <label class="form-check-label" for="packingItem4">Medications</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="packingItem5">
                        <label class="form-check-label" for="packingItem5">Electronics & Chargers</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Add item">
                    <button class="btn btn-primary" type="button">Add</button>
                </div>
            </div>
        </div>
        
        <!-- Notes -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Trip Notes</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <textarea class="form-control" rows="4" placeholder="Add notes about your trip...">Remember to exchange currency before departure. Check in online 24 hours before flight.</textarea>
                </div>
                <button class="btn btn-primary btn-sm">Save Notes</button>
            </div>
        </div>
    </div>
</div>

<!-- Nearby Points of Interest -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Nearby Points of Interest</h5>
        <a href="#" class="text-decoration-none">View all</a>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://images.unsplash.com/photo-{{ 1520250497591 + $i*30 }}-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="card-img-top" height="160" style="object-fit: cover;" alt="POI">
                        <div class="card-body">
                            <h5 class="card-title">Nearby Attraction {{ $i }}</h5>
                            <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i>2.{{ $i }} km from your destinations</p>
                            <p class="card-text small">A beautiful attraction near your planned destinations. Worth checking out during your trip.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <span class="small">4.{{ 7 + $i }} ({{ 70 + $i*10 }} reviews)</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary">Add to Trip</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script for toggling packing list items and saving trip notes
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Itinerary view loaded');
        // Add your JavaScript functionality here
    });
</script>
@endpush