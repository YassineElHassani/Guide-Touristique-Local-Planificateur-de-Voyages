@extends('client.dashboard')

@section('dashboard-title', 'Welcome Back, ' . (Auth::user()->first_name ?? ''))

@section('dashboard-actions')
<a href="#" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Create Blog
</a>
@endsection

@section('dashboard-content')
<!-- Stats Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-calendar-check text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Upcoming Trips</h6>
                        <h3 class="mb-0">2</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-route text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Itineraries</h6>
                        <h3 class="mb-0">5</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-heart text-danger fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Favorites</h6>
                        <h3 class="mb-0">12</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-star text-info fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Reviews</h6>
                        <h3 class="mb-0">8</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Trips Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Upcoming Trips</h5>
        <a href="#" class="text-decoration-none small">View all</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tour</th>
                        <th>Guide</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-2" width="50" height="50" alt="Paris Tour">
                                <div>
                                    <h6 class="mb-0">Paris Art and Culture Tour</h6>
                                    <small class="text-muted">Paris, France</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/women/11.jpg" class="rounded-circle me-2" width="32" height="32" alt="Guide">
                                <span>Marie Dubois</span>
                            </div>
                        </td>
                        <td>May 15, 2025</td>
                        <td><span class="badge bg-success">Confirmed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://images.unsplash.com/photo-1480796927426-f609979314bd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-2" width="50" height="50" alt="Tokyo Tour">
                                <div>
                                    <h6 class="mb-0">Tokyo Food Adventure</h6>
                                    <small class="text-muted">Tokyo, Japan</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/men/42.jpg" class="rounded-circle me-2" width="32" height="32" alt="Guide">
                                <span>Hiro Tanaka</span>
                            </div>
                        </td>
                        <td>June 10, 2025</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recommendations and Weather Row -->
<div class="row g-4">
    <!-- Recommended Tours -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recommended Tours</h5>
                <a href="#" class="text-decoration-none small">View more</a>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="card-img-top" height="160" style="object-fit: cover;" alt="Tour">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-info rounded-pill">Adventure</span>
                                    <span class="text-primary fw-bold">$189</span>
                                </div>
                                <h5 class="card-title mb-1">Santorini Island Exploration</h5>
                                <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i>Santorini, Greece</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <span>4.9 (56 reviews)</span>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1535139262971-c51845709a48?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="card-img-top" height="160" style="object-fit: cover;" alt="Tour">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-success rounded-pill">Nature</span>
                                    <span class="text-primary fw-bold">$150</span>
                                </div>
                                <h5 class="card-title mb-1">Bali Temple and Rice Fields</h5>
                                <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i>Bali, Indonesia</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <span>4.8 (124 reviews)</span>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Weather Widget -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Weather Forecast</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-sun fa-4x text-warning"></i>
                    </div>
                    <h2 class="mb-0">28°C</h2>
                    <p class="text-muted">Paris, France</p>
                </div>
                
                <div class="row g-2">
                    <div class="col-3">
                        <div class="text-center p-2 rounded bg-light">
                            <p class="small mb-1">Thu</p>
                            <i class="fas fa-cloud text-secondary"></i>
                            <p class="mb-0">24°C</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="text-center p-2 rounded bg-light">
                            <p class="small mb-1">Fri</p>
                            <i class="fas fa-cloud-sun text-secondary"></i>
                            <p class="mb-0">26°C</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="text-center p-2 rounded bg-light">
                            <p class="small mb-1">Sat</p>
                            <i class="fas fa-sun text-warning"></i>
                            <p class="mb-0">29°C</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="text-center p-2 rounded bg-light">
                            <p class="small mb-1">Sun</p>
                            <i class="fas fa-cloud-sun-rain text-secondary"></i>
                            <p class="mb-0">25°C</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="mb-3">Check weather for your trip:</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter location">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection