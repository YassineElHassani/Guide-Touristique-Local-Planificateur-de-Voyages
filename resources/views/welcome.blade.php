@extends('layouts.template')

@section('title', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">Discover Amazing Places Around The World</h1>
                    <p class="mb-5">Experience authentic local adventures with knowledgeable guides. Find the perfect destination, plan your trip, and create unforgettable memories.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#destinations" class="btn btn-primary btn-lg">Explore Destinations</a>
                        <a href="#" class="btn btn-outline-light btn-lg">Find Local Guides</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Search Form -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="search-form">
                    <form action="#" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Destination</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select class="form-select" name="destination">
                                        <option value="" selected>Where are you going?</option>
                                        <option value="paris">Paris, France</option>
                                        <option value="tokyo">Tokyo, Japan</option>
                                        <option value="rome">Rome, Italy</option>
                                        <option value="bali">Bali, Indonesia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Check In</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" name="check_in">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Duration</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <select class="form-select" name="duration">
                                        <option value="" selected>Duration</option>
                                        <option value="1-3">1-3 days</option>
                                        <option value="4-7">4-7 days</option>
                                        <option value="8-14">8-14 days</option>
                                        <option value="15+">15+ days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Popular Destinations -->
    <section class="py-5 mt-4" id="destinations">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold">Popular Destinations</h2>
                    <p class="text-muted">Explore our top destinations loved by travelers around the world</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="#" class="btn btn-outline-primary">View All Destinations</a>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Paris">
                        <span class="badge-featured">Featured</span>
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>France</span>
                            <h3>Paris</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="ms-2">4.8</span>
                                </div>
                                <span>10+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Rome">
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>Italy</span>
                            <h3>Rome</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <span class="ms-2">4.9</span>
                                </div>
                                <span>8+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1480796927426-f609979314bd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Tokyo">
                        <span class="badge-featured">Featured</span>
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>Japan</span>
                            <h3>Tokyo</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <span class="ms-2">4.7</span>
                                </div>
                                <span>12+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Tuscany">
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>Italy</span>
                            <h3>Tuscany</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="ms-2">4.8</span>
                                </div>
                                <span>7+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1535139262971-c51845709a48?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Bali">
                        <span class="badge-featured">Featured</span>
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>Indonesia</span>
                            <h3>Bali</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <span class="ms-2">5.0</span>
                                </div>
                                <span>15+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="destination-card shadow-md">
                        <img src="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" alt="Santorini">
                        <div class="destination-card-content">
                            <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>Greece</span>
                            <h3>Santorini</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="ms-2">4.8</span>
                                </div>
                                <span>9+ tours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Local Experiences -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold">Local Experiences</h2>
                    <p class="text-muted">Unique adventures guided by local experts</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="#" class="btn btn-outline-primary">View All Experiences</a>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600" class="card-img-top" alt="Food Tour">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary rounded-pill">Food & Culinary</span>
                                <span class="text-primary fw-bold">$89</span>
                            </div>
                            <h5 class="card-title">Authentic Street Food Tour</h5>
                            <p class="card-text">Taste the authentic flavors of local cuisine with our expert food guides.</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/women/45.jpg" class="rounded-circle" width="32" height="32" alt="Guide">
                                <span class="ms-2">Sarah Johnson</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <span>4.9 (127 reviews)</span>
                                </div>
                                <span><i class="fas fa-clock me-1"></i>3 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1540339832862-474599807836?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600" class="card-img-top" alt="Hiking">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success rounded-pill">Outdoor & Adventure</span>
                                <span class="text-primary fw-bold">$65</span>
                            </div>
                            <h5 class="card-title">Mountain Trekking Expedition</h5>
                            <p class="card-text">Explore breathtaking trails with our experienced mountain guides.</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle" width="32" height="32" alt="Guide">
                                <span class="ms-2">Michael Torres</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <span>4.8 (95 reviews)</span>
                                </div>
                                <span><i class="fas fa-clock me-1"></i>6 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600" class="card-img-top" alt="Cultural Workshop">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger rounded-pill">Arts & Culture</span>
                                <span class="text-primary fw-bold">$45</span>
                            </div>
                            <h5 class="card-title">Traditional Pottery Workshop</h5>
                            <p class="card-text">Learn the art of pottery from local artisans in this hands-on workshop.</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle" width="32" height="32" alt="Guide">
                                <span class="ms-2">Elena Rodriguez</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <span>4.7 (83 reviews)</span>
                                </div>
                                <span><i class="fas fa-clock me-1"></i>2 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1609845768806-767fcfc317b6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600" class="card-img-top" alt="Wine Tasting">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-info rounded-pill">Wine & Beverages</span>
                                <span class="text-primary fw-bold">$75</span>
                            </div>
                            <h5 class="card-title">Vineyard Tour & Wine Tasting</h5>
                            <p class="card-text">Explore local vineyards and taste premium wines with our sommelier.</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/men/52.jpg" class="rounded-circle" width="32" height="32" alt="Guide">
                                <span class="ms-2">Pierre Dubois</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-star text-warning"></i>
                                    <span>4.9 (112 reviews)</span>
                                </div>
                                <span><i class="fas fa-clock me-1"></i>4 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Why Choose Explore&Discover</h2>
                    <p class="text-muted">We provide exceptional travel experiences with our carefully selected local guides</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-check fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Expert Local Guides</h4>
                        <p class="text-muted">Our guides are carefully selected locals with deep knowledge of their regions.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-route fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Personalized Itineraries</h4>
                        <p class="text-muted">Create custom travel plans tailored to your interests and preferences.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Safe & Secure</h4>
                        <p class="text-muted">Your safety is our priority with vetted guides and secure booking system.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-heart fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Authentic Experiences</h4>
                        <p class="text-muted">Discover hidden gems and enjoy genuine cultural interactions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">What Our Travelers Say</h2>
                    <p class="text-muted">Read reviews from travelers who have experienced our guided tours</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="card-text">"Our guide Maria was phenomenal! She knew all the hidden spots in Rome and shared fascinating stories about the city's history. Best tour I've ever taken!"</p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle" width="48" height="48" alt="Customer">
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Robert Johnson</h6>
                                            <small class="text-muted">Rome, Italy Tour</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="card-text">"The personalized tour in Bali exceeded all my expectations. Our guide took us to beautiful temples and incredible beaches while sharing local traditions."</p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/women/63.jpg" class="rounded-circle" width="48" height="48" alt="Customer">
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Emily Wilson</h6>
                                            <small class="text-muted">Bali Cultural Tour</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                    <p class="card-text">"The food tour in Tokyo was the highlight of our trip! Our guide Akio introduced us to amazing dishes we would never have found on our own. Unforgettable experience!"</p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/men/22.jpg" class="rounded-circle" width="48" height="48" alt="Customer">
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">Daniel Kim</h6>
                                            <small class="text-muted">Tokyo Food Tour</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold">Ready to Start Your Adventure?</h2>
                    <p class="mb-0">Join thousands of travelers exploring the world with our expert guides</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Sign Up Now</a>
                </div>
            </div>
        </div>
    </section>
@endsection