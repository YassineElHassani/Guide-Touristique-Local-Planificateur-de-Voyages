@extends('guide.dashboard')

@section('dashboard-title', $event->name)
@section('dashboard-breadcrumb', 'Event Details')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.events.edit', $event->id) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Event
        </a>
    </div>
@endsection

@section('dashboard-content')
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $event->name }}</strong>?</p>
                    <p class="text-danger">This action cannot be undone and will remove all reservations for this event.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('guide.events.destroy', $event->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Event Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-calendar-alt fa-4x text-secondary"></i>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="mb-3">{{ $event->name }}</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-dollar-sign text-primary me-2"></i>
                                    <span>${{ number_format($event->price, 2) }} per person</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clipboard-check text-primary me-2"></i>
                                    @php
                                        $reservationCount = \App\Models\reservations::where('event_id', $event->id)
                                            ->whereIn('status', ['confirmed', 'pending'])
                                            ->count();
                                    @endphp
                                    <span>{{ $reservationCount }} reservations</span>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mb-3">Description</h5>
                        <p>{{ $event->description }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Reservations -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reservations</h5>
                    <a href="{{ route('guide.reservations.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $reservations = \App\Models\reservations::where('event_id', $event->id)
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();
                                @endphp
                                
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $avatar = $reservation->user && $reservation->user->picture
                                                        ? (Str::startsWith($reservation->user->picture, 'http')
                                                            ? $reservation->user->picture
                                                            : asset('storage/' . $reservation->user->picture))
                                                        : asset('/assets/images/default-avatar.png');
                                                @endphp
                                                <img src="{{ $avatar }}" class="rounded-circle me-2" width="40" height="40" alt="User">
                                                <div>
                                                    <h6 class="mb-0">{{ $reservation->user->first_name ?? 'Guest' }} {{ $reservation->user->last_name ?? '' }}</h6>
                                                    <small class="text-muted">{{ $reservation->user->email ?? 'No email' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = 'secondary';
                                                
                                                if ($reservation->status == 'pending') {
                                                    $statusClass = 'warning';
                                                } elseif ($reservation->status == 'confirmed') {
                                                    $statusClass = 'success';
                                                } elseif ($reservation->status == 'cancelled') {
                                                    $statusClass = 'danger';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ ucfirst($reservation->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('guide.reservations.show', $reservation->id) }}">
                                                            <i class="fas fa-eye me-2"></i> View Details
                                                        </a>
                                                    </li>
                                                    @if($reservation->status == 'pending')
                                                        <li>
                                                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-check me-2 text-success"></i> Confirm
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if($reservation->status != 'cancelled')
                                                        <li>
                                                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-times me-2 text-danger"></i> Cancel
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <h5>No Reservations Yet</h5>
                                                <p class="text-muted">This event doesn't have any reservations yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white p-3">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('guide.reservations.index') }}" class="btn btn-outline-primary">View All Reservations</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Event Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Statistics</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalReservations = \App\Models\reservations::where('event_id', $event->id)->count();
                        $confirmedReservations = \App\Models\reservations::where('event_id', $event->id)->where('status', 'confirmed')->count();
                        $pendingReservations = \App\Models\reservations::where('event_id', $event->id)->where('status', 'pending')->count();
                        $cancelledReservations = \App\Models\reservations::where('event_id', $event->id)->where('status', 'cancelled')->count();
                        $estimatedRevenue = $event->price * $confirmedReservations;
                    @endphp
                    
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Estimated Revenue</h6>
                        <h3 class="mb-0">${{ number_format($estimatedRevenue, 2) }}</h3>
                        <small class="text-muted">Based on price × confirmed reservations</small>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $totalReservations }}</h6>
                                            <small class="text-muted">Total</small>
                                        </div>
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2">
                                            <i class="fas fa-calendar-check text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $confirmedReservations }}</h6>
                                            <small class="text-muted">Confirmed</small>
                                        </div>
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $pendingReservations }}</h6>
                                            <small class="text-muted">Pending</small>
                                        </div>
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2">
                                            <i class="fas fa-clock text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $cancelledReservations }}</h6>
                                            <small class="text-muted">Cancelled</small>
                                        </div>
                                        <div class="rounded-circle bg-danger bg-opacity-10 p-2">
                                            <i class="fas fa-times-circle text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reviews</h5>
                    <a href="{{ route('guide.reviews') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @php
                        $reviews = \App\Models\reviews::where('event_id', $event->id)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
                        
                        $avgRating = $reviews->avg('rating') ?? 0;
                    @endphp
                    
                    <div class="mb-4 text-center">
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <h2 class="mb-0 me-2">{{ number_format($avgRating, 1) }}</h2>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <div class="text-muted small">{{ $reviews->count() }} reviews</div>
                            </div>
                        </div>
                    </div>
                    
                    @forelse($reviews as $review)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    @php
                                        $avatar = $review->user && $review->user->picture
                                            ? (Str::startsWith($review->user->picture, 'http')
                                                ? $review->user->picture
                                                : asset('storage/' . $review->user->picture))
                                            : asset('/assets/images/default-avatar.png');
                                    @endphp
                                    <img src="{{ $avatar }}" class="rounded-circle me-2" width="32" height="32" alt="User">
                                    <div>
                                        <h6 class="mb-0">{{ $review->user->first_name ?? 'Guest' }} {{ $review->user->last_name ?? '' }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning small"></i>
                                        @else
                                            <i class="far fa-star text-warning small"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5>No Reviews Yet</h5>
                            <p class="text-muted">This event hasn't received any reviews yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('guide.events.edit', $event->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Event
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i> Delete Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
