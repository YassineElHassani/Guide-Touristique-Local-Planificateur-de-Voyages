@extends('layouts.template')

@section('title', 'Welcome')

@php
    use App\Models\Blog;
    use App\Models\events;
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">Discover Amazing Places Around The World</h1>
                    <p class="mb-5">Experience authentic local adventures with knowledgeable guides. Find the perfect
                        destination, plan your trip, and create unforgettable memories.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-lg">Explore Destinations</a>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg">Find Local Guides</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Form -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="search-form bg-white shadow-lg rounded p-4"
                    style="margin-top: -50px; position: relative; z-index: 100;">
                    <form action="{{ route('events.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Destination</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select class="form-select" name="destination">
                                        <option value="" selected>Where are you going?</option>
                                        <option value="1">Paris, France</option>
                                        <option value="2">Tokyo, Japan</option>
                                        <option value="3">Rome, Italy</option>
                                        <option value="4">Barcelona, Spain</option>
                                        <option value="5">New York, USA</option>
                                        <option value="6">London, UK</option>
                                        <option value="7">Sydney, Australia</option>
                                        <option value="8">Dubai, UAE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Check In</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" name="date_from" min="{{ date('Y-m-d') }}">
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

    <!-- Featured Blogs -->
    <section class="py-5 mt-4" id="destinations">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h2 class="section-title">Featured Blogs</h2>
                    <p class="section-subtitle">Discover travel stories and tips from our community</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="{{ route('blogs.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-book-open me-2"></i> View All Blogs
                    </a>
                </div>
            </div>

            <div class="row g-4">
                @php
                    // Get featured and recent blogs
                    $featuredBlogs = Blog::published()->featured()->with('user')->take(3)->get();

                    $recentBlogs = Blog::published()
                        ->with('user')
                        ->withCount('comments')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();

                    // Combine and ensure no duplicates
                    $displayBlogs = $featuredBlogs->merge($recentBlogs)->unique('id')->take(6);
                @endphp

                @forelse($displayBlogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm rounded overflow-hidden">
                            @if ($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top"
                                    alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://images.unsplash.com/photo-1500835556837-99ac94a94552?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                    class="card-img-top" alt="{{ $blog->title }}"
                                    style="height: 200px; object-fit: cover;">
                            @endif

                            @if ($blog->featured)
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3">Featured</span>
                            @endif

                            <div class="card-body p-4">
                                @if ($blog->category)
                                    <span class="d-block mb-2 text-muted"><i
                                            class="fas fa-tag me-2"></i>{{ $blog->category }}</span>
                                @endif
                                <h3 class="h4">{{ $blog->title }}</h3>
                                <p class="text-muted">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $avatar = $blog->user->picture
                                                ? (Str::startsWith($blog->user->picture, 'http')
                                                    ? $blog->user->picture
                                                    : asset('storage/' . $blog->user->picture))
                                                : asset('/assets/images/default-avatar.png');
                                        @endphp
                                        <img src="{{ $avatar }}" class="rounded-circle" width="32" height="32" alt="{{ $blog->user->first_name }}">
                                        <span class="ms-2 small">{{ $blog->user->first_name ?? 'Anonymous' }}</span>
                                    </div>
                                    <span class="small text-muted"><i
                                            class="far fa-clock me-1"></i>{{ $blog->reading_time }} min read</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="small text-muted"><i
                                            class="far fa-calendar me-1"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                                    <span class="small text-muted"><i
                                            class="far fa-comment me-1"></i>{{ $blog->comments_count ?? 0 }}</span>
                                </div>

                                <a href="{{ route('blogs.show', $blog->slug) }}"
                                    class="btn btn-outline-primary w-100 mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                            <h3>No blog posts found</h3>
                            <p class="text-muted">Check back later for exciting travel stories!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold">Featured Experiences</h2>
                    <p class="text-muted">Unique adventures guided by local experts</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-primary">View All Experiences</a>
                </div>
            </div>

            <div class="row g-4">
                @php
                    // Get upcoming events
                    $upcomingEvents = events::orderBy('date', 'asc')->whereDate('date', '>=', now())->take(8)->get();

                    // Event categories with colors
                    $categoryColors = [
                        'Food & Culinary' => 'primary',
                        'Outdoor & Adventure' => 'success',
                        'Cultural' => 'info',
                        'Photography' => 'warning',
                        'City Tour' => 'secondary',
                        'Nature' => 'success',
                        'Historical' => 'danger',
                        'Art' => 'info',
                        'Music' => 'primary',
                        'Wellness' => 'light',
                    ];
                @endphp

                @forelse($upcomingEvents as $event)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                    alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80"
                                    class="card-img-top" alt="{{ $event->name }}"
                                    style="height: 200px; object-fit: cover;">
                            @endif

                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    @php
                                        // Determine category and color
                                        $category = 'Cultural'; // Default category
                                        if (
                                            stripos($event->name, 'food') !== false ||
                                            stripos($event->name, 'culinary') !== false ||
                                            stripos($event->name, 'taste') !== false
                                        ) {
                                            $category = 'Food & Culinary';
                                        } elseif (
                                            stripos($event->name, 'hike') !== false ||
                                            stripos($event->name, 'trek') !== false ||
                                            stripos($event->name, 'adventure') !== false
                                        ) {
                                            $category = 'Outdoor & Adventure';
                                        } elseif (
                                            stripos($event->name, 'photo') !== false ||
                                            stripos($event->name, 'camera') !== false
                                        ) {
                                            $category = 'Photography';
                                        } elseif (
                                            stripos($event->name, 'history') !== false ||
                                            stripos($event->name, 'heritage') !== false
                                        ) {
                                            $category = 'Historical';
                                        } elseif (
                                            stripos($event->name, 'art') !== false ||
                                            stripos($event->name, 'museum') !== false
                                        ) {
                                            $category = 'Art';
                                        } elseif (
                                            stripos($event->name, 'music') !== false ||
                                            stripos($event->name, 'concert') !== false
                                        ) {
                                            $category = 'Music';
                                        } elseif (
                                            stripos($event->name, 'nature') !== false ||
                                            stripos($event->name, 'garden') !== false
                                        ) {
                                            $category = 'Nature';
                                        }

                                        $color = $categoryColors[$category] ?? 'primary';
                                    @endphp
                                    <span class="badge bg-{{ $color }} rounded-pill">{{ $category }}</span>
                                    <span class="text-primary fw-bold">${{ number_format($event->price, 2) }}</span>
                                </div>
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 80) }}</p>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <span class="ms-2">Local Guide</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                        <span class="small">{{ $event->date->format('M d, Y') }}</span>
                                    </div>
                                    <span><i
                                            class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($event->location, 15) }}</span>
                                </div>
                                <a href="{{ route('events.show', $event->id) }}"
                                    class="btn btn-outline-primary w-100 mt-3">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
                            <h3>No upcoming events found</h3>
                            <p class="text-muted">Check back later for exciting experiences!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Why Choose Explore&Discover</h2>
                    <p class="text-muted">We provide exceptional travel experiences with our carefully selected local
                        guides</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-user-check fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Expert Local Guides</h4>
                        <p class="text-muted">Our guides are carefully selected locals with deep knowledge of their
                            regions.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-route fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Personalized Itineraries</h4>
                        <p class="text-muted">Create custom travel plans tailored to your interests and preferences.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Safe & Secure</h4>
                        <p class="text-muted">Your safety is our priority with vetted guides and secure booking system.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-4"
                            style="width: 80px; height: 80px;">
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
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="fw-bold">What Our Travelers Say</h2>
                    <p class="text-muted">Read reviews from travelers who have experienced our local guided tours</p>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @php
                    // Get top reviews directly from the reviews model
                    $topReviews = App\Models\reviews::with(['user', 'event'])
                        ->where('rating', '>=', 4)
                        ->orderBy('rating', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();

                    // If no reviews found, create sample ones
                    if ($topReviews->isEmpty()) {
                        $sampleReviews = [
                            [
                                'title' => 'Paris Walking Tour',
                                'rating' => 5,
                                'comment' =>
                                    'Our guide was exceptional! He showed us hidden gems in Paris that we would never have found on our own. His knowledge of the city\'s history made the experience unforgettable.',
                                'user_name' => 'Robert Johnson',
                                'date' => '1 month ago',
                            ],
                            [
                                'title' => 'Bali Cultural Tour',
                                'rating' => 5,
                                'comment' =>
                                    'The personalized tour in Bali exceeded all my expectations. Our guide took us to beautiful temples and incredible beaches while sharing local traditions.',
                                'user_name' => 'Emily Wilson',
                                'date' => '2 weeks ago',
                            ],
                            [
                                'title' => 'Tokyo Food Tour',
                                'rating' => 4.5,
                                'comment' =>
                                    'The food tour in Tokyo was the highlight of our trip! Our guide introduced us to amazing dishes we would never have found on our own. Unforgettable experience!',
                                'user_name' => 'Daniel Kim',
                                'date' => '3 weeks ago',
                            ],
                        ];
                    }
                @endphp

                @if ($topReviews->isNotEmpty())
                    @foreach ($topReviews as $review)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm p-4">
                                <div class="d-flex mb-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($review->rating))
                                            <i class="fas fa-star text-warning me-1"></i>
                                        @elseif($i - 0.5 <= $review->rating)
                                            <i class="fas fa-star-half-alt text-warning me-1"></i>
                                        @else
                                            <i class="far fa-star text-warning me-1"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 small">{{ number_format($review->rating, 1) }}</span>
                                </div>

                                <p class="card-text mb-4">"{{ Str::limit($review->comment, 200) }}"</p>

                                <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                    @if ($review->event)
                                        <span><i class="fas fa-map-marker-alt me-1"></i>{{ $review->event->name }}</span>
                                    @elseif($review->destination)
                                        <span><i
                                                class="fas fa-map-marker-alt me-1"></i>{{ $review->destination->name }}</span>
                                    @else
                                        <span><i class="fas fa-map-marker-alt me-1"></i>Tour Experience</span>
                                    @endif
                                    <span><i
                                            class="far fa-calendar-alt me-1"></i>{{ $review->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="d-flex align-items-center mt-auto">
                                    @if ($review->user && $review->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}"
                                            class="rounded-circle" width="48" height="48"
                                            alt="{{ $review->user->name }}">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $review->user->name ?? 'Happy Traveler' }}</h6>
                                        <small class="text-muted">Verified Traveler</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach ($sampleReviews as $review)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm p-4">
                                <div class="d-flex mb-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($review['rating']))
                                            <i class="fas fa-star text-warning me-1"></i>
                                        @elseif($i - 0.5 <= $review['rating'])
                                            <i class="fas fa-star-half-alt text-warning me-1"></i>
                                        @else
                                            <i class="far fa-star text-warning me-1"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 small">{{ number_format($review['rating'], 1) }}</span>
                                </div>

                                <p class="card-text mb-4">"{{ $review['comment'] }}"</p>

                                <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                    <span><i class="fas fa-map-marker-alt me-1"></i>{{ $review['title'] }}</span>
                                    <span><i class="far fa-calendar-alt me-1"></i>{{ $review['date'] }}</span>
                                </div>

                                <div class="d-flex align-items-center mt-auto">
                                    <img src="https://randomuser.me/api/portraits/{{ Str::contains(strtolower($review['user_name']), ['emily', 'sarah', 'jessica', 'anna']) ? 'women' : 'men' }}/{{ rand(1, 99) }}.jpg"
                                        class="rounded-circle" width="48" height="48"
                                        alt="{{ $review['user_name'] }}">
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $review['user_name'] }}</h6>
                                        <small class="text-muted">Verified Traveler</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold">Ready to Start Your Adventure?</h2>
                    <p class="lead mb-0">Join thousands of travelers exploring the world with our expert local guides</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @auth
                        <a href="{{ route('events.index') }}" class="btn btn-light btn-lg">Explore Events</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Sign Up Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection
