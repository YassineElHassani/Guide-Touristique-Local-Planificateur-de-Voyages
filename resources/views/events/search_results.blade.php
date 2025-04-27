@extends('layouts.template')

@section('title', 'Event Search Results')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fw-bold mb-2">Event Search Results</h1>
                <p class="lead mb-0">{{ $events->total() }} events found {{ !empty($query) ? 'for "' . $query . '"' : '' }}</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Filters</h4>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('events.search') }}" method="GET" id="filterForm">
                        <!-- Search Text -->
                        <div class="mb-3">
                            <label for="query" class="form-label">Search</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="query" name="query" placeholder="Search events..." value="{{ $query ?? '' }}">
                            </div>
                        </div>
                        
                        <!-- Date Filter -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $dateFilter ?? '' }}">
                            </div>
                            <div class="form-text small mt-1">Leave empty for all future events</div>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="price_min" placeholder="Min" value="{{ $priceMin ?? '' }}" min="0" step="0.01">
                                </div>
                                <div class="mx-2">-</div>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="price_max" placeholder="Max" value="{{ $priceMax ?? '' }}" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($categoryId) && $categoryId == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Location -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select" id="location" name="location">
                                <option value="">All Locations</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ (isset($location) && $location == $loc) ? 'selected' : '' }}>
                                        {{ $loc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort By -->
                        <div class="mb-3">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="date_asc" {{ (isset($sortBy) && $sortBy == 'date_asc') ? 'selected' : '' }}>Date (Soonest First)</option>
                                <option value="date_desc" {{ (isset($sortBy) && $sortBy == 'date_desc') ? 'selected' : '' }}>Date (Latest First)</option>
                                <option value="price_asc" {{ (isset($sortBy) && $sortBy == 'price_asc') ? 'selected' : '' }}>Price (Low to High)</option>
                                <option value="price_desc" {{ (isset($sortBy) && $sortBy == 'price_desc') ? 'selected' : '' }}>Price (High to Low)</option>
                                <option value="name_asc" {{ (isset($sortBy) && $sortBy == 'name_asc') ? 'selected' : '' }}>Name (A-Z)</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i> Apply Filters
                            </button>
                            <a href="{{ route('events.search') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Quick Filters</h4>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('events.search', ['date' => \Carbon\Carbon::today()->format('Y-m-d')]) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-calendar-day text-primary me-2"></i> Today's Events
                        </a>
                        <a href="{{ route('events.search', ['date' => \Carbon\Carbon::tomorrow()->format('Y-m-d')]) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-calendar-alt text-primary me-2"></i> Tomorrow's Events
                        </a>
                        <a href="{{ route('events.search', ['date_range' => 'weekend']) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-glass-cheers text-primary me-2"></i> Weekend Events
                        </a>
                        <a href="{{ route('events.search', ['sort_by' => 'price_asc', 'price_max' => 25]) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-tag text-primary me-2"></i> Budget-Friendly (Under $25)
                        </a>
                        <a href="{{ route('events.search', ['sort_by' => 'date_asc']) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-clock text-primary me-2"></i> Upcoming Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Events Grid -->
        <div class="col-lg-9">
            <!-- Active Filters -->
            @if(!empty($query) || !empty($dateFilter) || !empty($priceMin) || !empty($priceMax) || !empty($categoryId) || !empty($location))
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                    <span class="fw-bold">Active Filters:</span>
                    
                    @if(!empty($query))
                        <span class="badge bg-primary rounded-pill d-flex align-items-center">
                            Search: {{ $query }}
                            <a href="{{ route('events.search', array_merge(request()->except('query'), ['page' => 1])) }}" class="ms-2 text-white" style="text-decoration: none;">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    
                    @if(!empty($dateFilter))
                        <span class="badge bg-primary rounded-pill d-flex align-items-center">
                            Date: {{ \Carbon\Carbon::parse($dateFilter)->format('M d, Y') }}
                            <a href="{{ route('events.search', array_merge(request()->except('date'), ['page' => 1])) }}" class="ms-2 text-white" style="text-decoration: none;">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    
                    @if(!empty($priceMin) || !empty($priceMax))
                        <span class="badge bg-primary rounded-pill d-flex align-items-center">
                            Price: 
                            @if(!empty($priceMin) && !empty($priceMax))
                                ${{ $priceMin }} - ${{ $priceMax }}
                            @elseif(!empty($priceMin))
                                ${{ $priceMin }}+
                            @else
                                Up to ${{ $priceMax }}
                            @endif
                            <a href="{{ route('events.search', array_merge(request()->except(['price_min', 'price_max']), ['page' => 1])) }}" class="ms-2 text-white" style="text-decoration: none;">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    
                    @if(!empty($categoryId))
                        @php
                            $categoryName = $categories->where('id', $categoryId)->first()->name ?? 'Category';
                        @endphp
                        <span class="badge bg-primary rounded-pill d-flex align-items-center">
                            Category: {{ $categoryName }}
                            <a href="{{ route('events.search', array_merge(request()->except('category_id'), ['page' => 1])) }}" class="ms-2 text-white" style="text-decoration: none;">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    
                    @if(!empty($location))
                        <span class="badge bg-primary rounded-pill d-flex align-items-center">
                            Location: {{ $location }}
                            <a href="{{ route('events.search', array_merge(request()->except('location'), ['page' => 1])) }}" class="ms-2 text-white" style="text-decoration: none;">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    
                    <a href="{{ route('events.search') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                        <i class="fas fa-times me-1"></i> Clear All
                    </a>
                </div>
            @endif
            
            <!-- Results Count and Sort Options (Mobile) -->
            <div class="d-flex justify-content-between align-items-center mb-4 d-lg-none">
                <p class="mb-0"><span class="fw-bold">{{ $events->total() }}</span> results</p>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="mobileSortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i> Sort
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileSortDropdown">
                        <li><a class="dropdown-item {{ (isset($sortBy) && $sortBy == 'date_asc') ? 'active' : '' }}" href="{{ route('events.search', array_merge(request()->except('sort_by'), ['sort_by' => 'date_asc'])) }}">Date (Soonest First)</a></li>
                        <li><a class="dropdown-item {{ (isset($sortBy) && $sortBy == 'date_desc') ? 'active' : '' }}" href="{{ route('events.search', array_merge(request()->except('sort_by'), ['sort_by' => 'date_desc'])) }}">Date (Latest First)</a></li>
                        <li><a class="dropdown-item {{ (isset($sortBy) && $sortBy == 'price_asc') ? 'active' : '' }}" href="{{ route('events.search', array_merge(request()->except('sort_by'), ['sort_by' => 'price_asc'])) }}">Price (Low to High)</a></li>
                        <li><a class="dropdown-item {{ (isset($sortBy) && $sortBy == 'price_desc') ? 'active' : '' }}" href="{{ route('events.search', array_merge(request()->except('sort_by'), ['sort_by' => 'price_desc'])) }}">Price (High to Low)</a></li>
                        <li><a class="dropdown-item {{ (isset($sortBy) && $sortBy == 'name_asc') ? 'active' : '' }}" href="{{ route('events.search', array_merge(request()->except('sort_by'), ['sort_by' => 'name_asc'])) }}">Name (A-Z)</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Events Grid -->
            <div class="row g-4 mb-4">
                @forelse($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">{{ $event->category_id ? \App\Models\categories::find($event->category_id)->name ?? 'Event' : 'Event' }}</span>
                                    <span class="badge bg-secondary">${{ number_format($event->price, 2) }}</span>
                                </div>
                                <h5 class="card-title mb-2">{{ $event->name }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}
                                </p>
                                <p class="card-text text-muted small mb-3">
                                    <i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                    @if($event->time)
                                    <i class="fas fa-clock ms-2 me-1"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                    @endif
                                </p>
                                <p class="card-text mb-4">{{ Str::limit($event->description, 100) }}</p>
                                
                                @php
                                    $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->where('status', 'confirmed')->count();
                                    $availableSpots = ($event->capacity ?? 20) - $reservationsCount;
                                @endphp
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-users me-1"></i> 
                                            {{ $availableSpots }} of {{ $event->capacity ?? 20 }} spots left
                                        </small>
                                        
                                        @if(\Carbon\Carbon::parse($event->date)->isPast())
                                            <span class="badge bg-danger">Ended</span>
                                        @elseif($availableSpots <= 0)
                                            <span class="badge bg-warning">Sold Out</span>
                                        @elseif(\Carbon\Carbon::parse($event->date)->isToday())
                                            <span class="badge bg-success">Today</span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3>No Events Found</h3>
                        <p class="text-muted">We couldn't find any events matching your criteria. Try adjusting your filters or search for something else.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-calendar me-2"></i> Browse All Events
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $events->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-lg rounded-lg p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h3 class="fw-bold">Never Miss an Event</h3>
                            <p class="text-muted mb-0">Subscribe to receive updates on new events, special offers, and travel tips.</p>
                        </div>
                        <div class="col-lg-6">
                            <form>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Your email address">
                                    <button class="btn btn-primary" type="button">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Initialize filters that need JavaScript interaction
    document.addEventListener('DOMContentLoaded', function() {
        // Filter form auto-submit on select change
        const autoSubmitSelects = document.querySelectorAll('#sort_by, #category_id, #location');
        autoSubmitSelects.forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    });
</script>
@endpush