<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - GeoNoMad</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/app/css/style.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <i class="fas fa-compass me-2"></i>
                Geo<span class="text-primary">No</span>Mad
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @guest
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('destinations.index') ? 'active' : '' }}" href="{{ route('destinations.index') }}">Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('events.index') ? 'active' : '' }}" href="{{ route('events.index') }}">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                @elseif (Auth::user()->role == 'admin')
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                        </li>
                    </ul>
                @elseif (Auth::user()->role == 'travler')
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('client.home') ? 'active' : '' }}" href="{{ route('client.home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                @elseif (Auth::user()->role == 'guide')
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guide.home') ? 'active' : '' }}" href="{{ route('guide.home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                    @endif
                    <div class="ms-lg-3 mt-3 mt-lg-0 d-flex gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @php
                                        $avatar = Auth::user()->picture
                                            ? (Str::startsWith(Auth::user()->picture, 'http')
                                                ? Auth::user()->picture
                                                : asset('storage/' . Auth::user()->picture))
                                            : asset('/assets/images/default-avatar.png');
                                    @endphp
                                    <img src="{{ $avatar }}" alt="{{ Auth::user()->first_name }}" alt="User"
                                        height="40px" width="40px" style="border-radius: 2rem" class="user-avatar me-3" />
                                    {{ Auth::user()->first_name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    @if (Auth::user()->role === 'admin')
                                        <li><a class="dropdown-item" href="{{ route('users.profile', Auth::id()) }}">My Profile</a></li>
                                    @elseif (Auth::user()->role === 'guide')
                                        <li><a class="dropdown-item" href="{{ route('guide.profile.show') }}">My Profile</a></li>
                                    @elseif (Auth::user()->role === 'travler')
                                        <li><a class="dropdown-item" href="{{ route('client.profile.show') }}">My Profile</a></li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5>Geo<span class="text-primary">No</span>Mad</h5>
                        <p class="mb-4">Your trusted travel companion for exploring the world's most breathtaking
                            destinations with knowledgeable local guides.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('events.index') }}">Events</a></li>
                            <li><a href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h5>Support</h5>
                        <ul>
                            <li><a href="{{ route('contact') }}">Help Center</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h5>Newsletter</h5>
                        <p>Subscribe to our newsletter to receive updates on new destinations and offers.</p>
                        <form class="mt-3">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Your Email Address"
                                    aria-label="Your Email Address">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer-bottom text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} GeoNoMad. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>

    </html>
