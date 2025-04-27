@extends('guide.dashboard')

@section('dashboard-title', 'Reservation Details')
@section('dashboard-breadcrumb', 'Reservation Details')

@section('dashboard-actions')
    <a href="{{ route('guide.reservations.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-1"></i> Back to Reservations
    </a>
@endsection

@section('dashboard-content')
    <div class="row g-4">
        <!-- Reservation Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reservation #{{ $reservation->id }}</h5>
                    <div>
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Event Details</h6>
                            <div class="d-flex mb-3">
                                @if($reservation->event && $reservation->event->image)
                                    <img src="{{ asset('storage/' . $reservation->event->image) }}" class="rounded me-3" width="80" height="80" style="object-fit: cover;" alt="{{ $reservation->event->name }}">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-calendar-alt fa-2x text-secondary"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $reservation->event->name ?? 'Unknown Event' }}</h5>
                                    <p class="text-muted mb-0">{{ $reservation->event->location ?? 'Unknown Location' }}</p>
                                    <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($reservation->date)->format('F d, Y') }}</p>
                                </div>
                            </div>
                            
                            @if($reservation->event)
                                <a href="{{ route('guide.events.show', $reservation->event->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> View Event
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Customer Information</h6>
                            <div class="d-flex mb-3">
                                @php
                                    $avatar = $reservation->user && $reservation->user->picture
                                        ? (Str::startsWith($reservation->user->picture, 'http')
                                            ? $reservation->user->picture
                                            : asset('storage/' . $reservation->user->picture))
                                        : asset('/assets/images/default-avatar.png');
                                @endphp
                                <img src="{{ $avatar }}" class="rounded-circle me-3" width="60" height="60" alt="User">
                                <div>
                                    <h5 class="mb-1">{{ $reservation->user->first_name ?? 'Guest' }} {{ $reservation->user->last_name ?? '' }}</h5>
                                    <p class="text-muted mb-0">{{ $reservation->user->email ?? 'No email' }}</p>
                                    <p class="text-muted mb-0">{{ $reservation->user->phone ?? 'No phone' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Reservation Details</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Reservation Date:</span>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($reservation->date)->format('F d, Y') }}</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Number of Guests:</span>
                                    <span class="fw-bold">{{ $reservation->guests }}</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Price per Person:</span>
                                    <span class="fw-bold">${{ number_format($reservation->event->price ?? 0, 2) }}</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Total Price:</span>
                                    <span class="fw-bold">${{ number_format($reservation->total_price, 2) }}</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Booked On:</span>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($reservation->created_at)->format('M d, Y, h:i A') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Special Requests</h6>
                            @if($reservation->special_requests)
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{{ $reservation->special_requests }}</p>
                                </div>
                            @else
                                <div class="p-3 bg-light rounded">
                                    <p class="text-muted mb-0">No special requests provided.</p>
                                </div>
                            @endif
                            
                            @if($reservation->notes)
                                <h6 class="text-muted mb-2 mt-4">Internal Notes</h6>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{{ $reservation->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="text-muted mb-3">Update Reservation Status</h6>
                    <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-md-8">
                            <select class="form-select" name="status" id="status">
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Communication History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Communication History</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <form action="#" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="message" class="form-label">Send Message to Customer</label>
                                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Type your message here..."></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="timeline">
                        <!-- For a real application, you would loop through actual messages here -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="fw-bold">System</span>
                                        <span class="text-muted small ms-2">{{ \Carbon\Carbon::parse($reservation->created_at)->format('M d, Y, h:i A') }}</span>
                                    </div>
                                </div>
                                <p class="mb-0">Reservation was created.</p>
                            </div>
                        </div>
                        
                        @if($reservation->status != 'pending')
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator bg-{{ $reservation->status == 'confirmed' ? 'success' : 'danger' }}"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span class="fw-bold">System</span>
                                            <span class="text-muted small ms-2">{{ \Carbon\Carbon::parse($reservation->updated_at)->format('M d, Y, h:i A') }}</span>
                                        </div>
                                    </div>
                                    <p class="mb-0">Reservation status was updated to <span class="fw-bold">{{ ucfirst($reservation->status) }}</span>.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($reservation->status == 'pending')
                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-1"></i> Confirm Reservation
                                </button>
                            </form>
                        @endif
                        
                        @if($reservation->status != 'cancelled')
                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-times me-1"></i> Cancel Reservation
                                </button>
                            </form>
                        @endif
                        
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addNotesModal">
                            <i class="fas fa-sticky-note me-1"></i> Add Internal Notes
                        </button>
                        
                        <a href="#" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-print me-1"></i> Print Reservation
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Other Reservations -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Other Reservations by This Customer</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $otherReservations = \App\Models\reservations::where('user_id', $reservation->user_id)
                            ->where('id', '!=', $reservation->id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($otherReservations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($otherReservations as $otherReservation)
                                <a href="{{ route('guide.reservations.show', $otherReservation->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $otherReservation->event->name ?? 'Unknown Event' }}</h6>
                                            <p class="text-muted small mb-0">
                                                {{ \Carbon\Carbon::parse($otherReservation->date)->format('M d, Y') }} • 
                                                {{ $otherReservation->guests }} guests
                                            </p>
                                        </div>
                                        <span class="badge bg-{{ $otherReservation->status == 'pending' ? 'warning' : ($otherReservation->status == 'confirmed' ? 'success' : 'danger') }}">
                                            {{ ucfirst($otherReservation->status) }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center">
                            <i class="fas fa-calendar-alt fa-2x text-muted mb-3"></i>
                            <p class="mb-0">No other reservations found for this customer.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Notes Modal -->
    <div class="modal fade" id="addNotesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Internal Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (only visible to you)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ $reservation->notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Notes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.5rem;
        height: 100%;
        border-left: 1px dashed #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-item-marker {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
        height: 1rem;
        margin-top: 0.25rem;
    }
    
    .timeline-item-marker-indicator {
        display: block;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 100%;
    }
    
    .timeline-item-content {
        padding-left: 0.5rem;
    }
</style>
@endpush
