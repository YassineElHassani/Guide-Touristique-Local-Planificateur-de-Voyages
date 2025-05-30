@extends('layouts.template')

@section('title', $event->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Event Details -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    @if ($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}"
                            style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="fas fa-calendar-alt fa-5x text-secondary"></i>
                        </div>
                    @endif
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span
                                class="badge bg-primary">{{ $event->category_id ? \App\Models\categories::find($event->category_id)->name ?? 'Event' : 'Event' }}</span>
                            <div>
                                <span class="badge bg-secondary">${{ number_format($event->price, 2) }}</span>
                                @if (\Carbon\Carbon::parse($event->date)->isPast())
                                    <span class="badge bg-danger ms-1">Event Ended</span>
                                @elseif(\Carbon\Carbon::parse($event->date)->isToday())
                                    <span class="badge bg-success ms-1">Today</span>
                                @elseif(\Carbon\Carbon::parse($event->date)->diffInDays(\Carbon\Carbon::now()) <= 7)
                                    <span class="badge bg-warning ms-1">Coming Soon</span>
                                @endif
                            </div>
                        </div>

                        <h2 class="mb-4">{{ $event->name }}</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Location</p>
                                        <p class="mb-0"><strong>{{ $event->location }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar-day text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Date & Time</p>
                                        <p class="mb-0">
                                            <strong>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                                @if (isset($event->time))
                                                    at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                                @endif
                                            </strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-users text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Group Size</p>
                                        <p class="mb-0"><strong>{{ $event->capacity ?? 20 }} people max</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Duration</p>
                                        <p class="mb-0"><strong>{{ $event->duration ?? 2 }} hours</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3">About This Event</h4>
                        <p class="mb-4">{{ $event->description }}</p>

                        @if (isset($event->requirements) && $event->requirements)
                            <h4 class="mb-3">Requirements</h4>
                            <p class="mb-4">{{ $event->requirements }}</p>
                        @endif

                        @if (isset($event->itinerary) && $event->itinerary)
                            <h4 class="mb-3">Itinerary</h4>
                            <div class="mb-4">
                                @foreach (explode("\n", $event->itinerary) as $item)
                                    @if (trim($item))
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="bg-primary text-white rounded-circle p-2 me-3"
                                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <span>{{ $loop->iteration }}</span>
                                            </div>
                                            <div>
                                                <p class="mb-0">{{ trim($item) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reviews -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Reviews</h4>
                        <span class="badge bg-primary rounded-pill">{{ $reviews->count() }} Reviews</span>
                    </div>
                    <div class="card-body p-4">
                        @if ($reviews->count() > 0)
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2">
                                        <span class="h4 mb-0">{{ number_format($averageRating, 1) }}</span>
                                        <span class="text-muted">/5</span>
                                    </div>
                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($averageRating))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i - 0.5 <= $averageRating)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted">Based on {{ $reviews->count() }} reviews</p>
                            </div>

                            <div class="border-top pt-4">
                                @foreach ($reviews->sortByDesc('created_at')->take(5) as $review)
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $reviewAvatar =
                                                        $review->user && $review->user->picture
                                                            ? (Str::startsWith($review->user->picture, 'http')
                                                                ? $review->user->picture
                                                                : asset('storage/' . $review->user->picture))
                                                            : asset('/assets/images/default-avatar.png');
                                                @endphp
                                                <img src="{{ $reviewAvatar }}" class="rounded-circle" width="48"
                                                    height="48" alt="{{ $review->user->first_name ?? 'User' }}">
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">{{ $review->user->first_name ?? 'Anonymous' }}
                                                    {{ $review->user->last_name ?? '' }}</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                @endforeach

                                @if ($reviews->count() > 5)
                                    <div class="text-center">
                                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#moreReviews">
                                            <i class="fas fa-chevron-down me-1"></i> Show More Reviews
                                        </button>
                                    </div>

                                    <div class="collapse mt-4" id="moreReviews">
                                        @foreach ($reviews->sortByDesc('created_at')->slice(5) as $review)
                                            <div class="mb-4 pb-4 border-bottom">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-shrink-0">
                                                        @if (isset($review->user) && isset($review->user->picture))
                                                            <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}"
                                                                alt="{{ $review->user->name }}" class="rounded-circle"
                                                                width="50" height="50" style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                                style="width: 50px; height: 50px;">
                                                                <i class="fas fa-user text-primary"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="mb-1">
                                                            {{ isset($review->user) ? $review->user->first_name : 'Anonymous' }}
                                                        </h5>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @else
                                                                        <i class="far fa-star text-warning"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <span
                                                                class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-0">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                <h5>No Reviews Yet</h5>
                                <p class="text-muted">Be the first to review this event after your experience.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Booking Card -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0">Book This Event</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Price per person</span>
                                <span class="h5 mb-0">${{ number_format($event->price, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Available spots</span>
                                <span
                                    class="badge {{ $availableSpots > 5 ? 'bg-success' : ($availableSpots > 0 ? 'bg-warning' : 'bg-danger') }} rounded-pill">{{ $availableSpots }}
                                    / {{ $event->capacity ?? 20 }}</span>
                            </div>
                        </div>

                        @if (\Carbon\Carbon::parse($event->date)->isPast())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i> This event has already ended.
                            </div>
                        @elseif($availableSpots <= 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle me-2"></i> This event is fully booked.
                            </div>
                        @else
                            @auth
                                <form action="{{ route('client.reservations.store', $event->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="participants" class="form-label">Number of Participants</label>
                                        <select class="form-select" id="participants" name="participants" required>
                                            @for ($i = 1; $i <= min(10, $availableSpots); $i++)
                                                <option value="{{ $i }}">{{ $i }}
                                                    {{ $i == 1 ? 'person' : 'people' }}
                                                    (${{ number_format($event->price * $i, 2) }})</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-ticket-alt me-2"></i> Book Now
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="d-grid gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login to Book
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-2"></i> Don't have an account? Sign up
                                    </a>
                                </div>
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Guide Info -->
                @if ($guide)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0">About the Guide</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                @if (isset($guide->profile_photo_path))
                                    <img src="{{ asset('storage/' . $guide->profile_photo_path) }}"
                                        alt="{{ $guide->name }}" class="rounded-circle mb-3" width="100"
                                        height="100" style="object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 100px; height: 100px;">
                                        <i class="fas fa-user fa-3x text-primary"></i>
                                    </div>
                                @endif
                                <h5>{{ $guide->name }}</h5>
                                <p class="text-muted mb-0">Local Guide</p>
                            </div>

                            @if (isset($guide->bio))
                                <p class="mb-4">{{ $guide->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Similar Events -->
                @if ($similarEvents->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0">Similar Events</h4>
                        </div>
                        <div class="card-body p-4">
                            @foreach ($similarEvents as $similarEvent)
                                <div class="d-flex mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                                    <div class="flex-shrink-0">
                                        @if ($similarEvent->image)
                                            <img src="{{ asset('storage/' . $similarEvent->image) }}"
                                                alt="{{ $similarEvent->name }}" class="rounded" width="80"
                                                height="80" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                style="width: 80px; height: 80px;">
                                                <i class="fas fa-calendar-alt fa-2x text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ $similarEvent->name }}</h6>
                                        <p class="text-muted small mb-1">
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $similarEvent->location }}
                                        </p>
                                        <p class="text-muted small mb-1">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ \Carbon\Carbon::parse($similarEvent->date)->format('M d, Y') }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span
                                                class="badge bg-secondary">${{ number_format($similarEvent->price, 2) }}</span>
                                            <a href="{{ route('events.show', $similarEvent->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-grid mt-3">
                                <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-2"></i> Explore All Events
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .sticky-top {
                top: 80px;
            }
        </style>
    @endpush

@endsection
