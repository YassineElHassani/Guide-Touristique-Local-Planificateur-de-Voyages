@extends('layouts.template')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fw-bold mb-3">About Guide Touristique Local</h1>
                <p class="lead mb-0">Connecting travelers with authentic local experiences since 2020</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <!-- Our Story -->
    <div class="row align-items-center mb-5 pb-5 border-bottom">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="https://images.unsplash.com/photo-1522199755839-a2bacb67c546?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80" alt="Our Story" class="img-fluid rounded-3 shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">Our Story</h2>
            <p class="mb-4">Guide Touristique Local was founded in 2020 with a simple mission: to connect travelers with authentic local experiences led by passionate guides who know their regions best.</p>
            <p class="mb-4">What started as a small platform in Morocco has grown into a thriving community of guides and travelers across the country, all united by the belief that the best way to experience a destination is through the eyes of a local.</p>
            <p>Our platform empowers local guides to share their knowledge and passion while providing travelers with unforgettable, authentic experiences that go beyond typical tourist attractions.</p>
        </div>
    </div>
    
    <!-- Our Mission -->
    <div class="row mb-5 pb-5 border-bottom">
        <div class="col-lg-12 text-center mb-5">
            <h2 class="fw-bold mb-4">Our Mission</h2>
            <p class="lead mb-0 mx-auto" style="max-width: 800px;">To create meaningful connections between travelers and local guides, fostering cultural exchange and sustainable tourism that benefits local communities.</p>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-4">
                        <i class="fas fa-handshake fa-2x text-info"></i>
                    </div>
                    <h4 class="mb-3">Authentic Connections</h4>
                    <p class="text-muted mb-0">We believe in creating genuine connections between travelers and local guides who are passionate about sharing their culture and knowledge.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-4">
                        <i class="fas fa-leaf fa-2x text-info"></i>
                    </div>
                    <h4 class="mb-3">Sustainable Tourism</h4>
                    <p class="text-muted mb-0">We promote responsible travel practices that respect local communities, preserve cultural heritage, and protect the environment.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-4">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                    <h4 class="mb-3">Community Support</h4>
                    <p class="text-muted mb-0">We empower local guides and businesses, ensuring that tourism benefits the communities that make each destination special.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Team -->
    <div class="row mb-5 pb-5 border-bottom">
        <div class="col-lg-12 text-center mb-5">
            <h2 class="fw-bold mb-4">Meet Our Team</h2>
            <p class="lead mb-0 mx-auto" style="max-width: 800px;">Our diverse team of travel enthusiasts is dedicated to creating the best platform for guides and travelers alike.</p>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" class="card-img-top" alt="Team Member">
                <div class="card-body text-center p-4">
                    <h5 class="mb-1">Mohammed Alami</h5>
                    <p class="text-muted small mb-3">Founder & CEO</p>
                    <p class="mb-3">Former tour guide with a passion for connecting people and cultures.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=688&q=80" class="card-img-top" alt="Team Member">
                <div class="card-body text-center p-4">
                    <h5 class="mb-1">Amina Benali</h5>
                    <p class="text-muted small mb-3">Chief Operations Officer</p>
                    <p class="mb-3">Travel industry veteran with expertise in sustainable tourism practices.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" class="card-img-top" alt="Team Member">
                <div class="card-body text-center p-4">
                    <h5 class="mb-1">Youssef Mansouri</h5>
                    <p class="text-muted small mb-3">Head of Technology</p>
                    <p class="mb-3">Tech innovator focused on creating seamless experiences for users.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80" class="card-img-top" alt="Team Member">
                <div class="card-body text-center p-4">
                    <h5 class="mb-1">Leila Tazi</h5>
                    <p class="text-muted small mb-3">Guide Relations Manager</p>
                    <p class="mb-3">Former guide who ensures our platform meets the needs of local guides.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="row">
        <div class="col-lg-12 text-center mb-5">
            <h2 class="fw-bold mb-4">What People Say About Us</h2>
            <p class="lead mb-0 mx-auto" style="max-width: 800px;">Don't just take our word for it - hear from our community of guides and travelers.</p>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" alt="Testimonial" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Omar Kabbaj</h5>
                            <p class="text-muted mb-0">Local Guide in Marrakech</p>
                        </div>
                    </div>
                    <p class="mb-0">"This platform has transformed my career as a guide. I now have a steady stream of clients who are genuinely interested in authentic experiences, and I can focus on what I love - sharing my city's culture and history."</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" alt="Testimonial" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Sarah Johnson</h5>
                            <p class="text-muted mb-0">Traveler from Canada</p>
                        </div>
                    </div>
                    <p class="mb-0">"Our tour with a local guide in Fes was the highlight of our trip to Morocco. We experienced the city in a way that would have been impossible on our own. The booking process was seamless, and our guide was exceptional."</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" alt="Testimonial" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Miguel Sanchez</h5>
                            <p class="text-muted mb-0">Traveler from Spain</p>
                        </div>
                    </div>
                    <p class="mb-0">"We booked a desert tour through this platform and had an amazing experience. Our guide knew all the best spots away from the crowds and shared fascinating stories about local traditions. Highly recommended!"</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1534751516642-a1af1ef26a56?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=689&q=80" alt="Testimonial" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Fatima El Ouazzani</h5>
                            <p class="text-muted mb-0">Local Guide in Chefchaouen</p>
                        </div>
                    </div>
                    <p class="mb-0">"As a female guide in a small city, this platform has given me the opportunity to build a sustainable business doing what I love. The support from the team has been incredible, and I've met amazing people from around the world."</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-4">Join Our Community</h2>
                <p class="lead mb-4">Whether you're a traveler seeking authentic experiences or a guide wanting to share your passion, we'd love to welcome you to our community.</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Sign Up Now</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-4">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection