@extends('admin.layout')

@section('title', 'Reservation Details')

@push('styles')
<style>
    .status-badge {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
    }
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    .event-image {
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
    }
    .info-card {
        height: 50%;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .timeline {
        position: relative;
        padding-left: 45px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: #e0e0e0;
    }
    .timeline-item .timeline-dot {
        position: absolute;
        left: -38px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #6c757d;
        z-index: 1;
    }
    .timeline-item .timeline-dot.active {
        border-color: #28a745;
    }
    .timeline-item .timeline-dot.cancelled {
        border-color: #dc3545;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    .avatar-lg {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
    }
    .user-details-card {
        border-left: 4px solid #4e73df;
    }
    .event-details-card {
        border-left: 4px solid #1cc88a;
    }
    .reservation-details-card {
        border-left: 4px solid #f6c23e;
    }
    .notes-card {
        border-left: 4px solid #36b9cc;
    }
</style>
@endpush

@section('content')
<!-- Page header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Reservation Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">Reservations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Status and quick actions -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6 d-flex align-items-center">
                <div class="me-3">
                    <span class="text-muted">Reservation ID:</span>
                    <h4 class="mb-0">#{{ $reservation->id }}</h4>
                </div>
                <div class="ms-3">
                    <span class="text-muted">Status:</span>
                    <span class="status-badge status-{{ $reservation->status }} ms-2">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#statusModal">
                    <i class="fas fa-edit"></i> Update Status
                </button>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left column: User and Event Info -->
    <div class="col-lg-8">
        <!-- User Information -->
        <div class="card info-card user-details-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                @if($reservation->user)
                    <div class="row">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            @php
                                $avatar = $reservation->user->picture
                                    ? (Str::startsWith($reservation->user->picture, 'http')
                                        ? $reservation->user->picture
                                        : asset('storage/' . $reservation->user->picture))
                                    : asset('/assets/images/default-avatar.png');
                            @endphp
                            <img src="{{ $avatar }}" class="avatar-lg mb-2" alt="{{ $reservation->user->first_name }}">
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Full Name</label>
                                    <div class="fw-bold">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Email</label>
                                    <div class="fw-bold">{{ $reservation->user->email }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Phone</label>
                                    <div class="fw-bold">{{ $reservation->user->phone_number ?? 'Not provided' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">Member Since</label>
                                    <div class="fw-bold">{{ $reservation->user->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <a href="{{ route('admin.users.show', $reservation->user->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-user me-1"></i> View Profile
                                </a>
                                <a href="mailto:{{ $reservation->user->email }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-envelope me-1"></i> Send Email
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h5>User information not available</h5>
                        <p class="text-muted">The user associated with this reservation may have been deleted.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Event Information -->
        <div class="card info-card event-details-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Event Information</h5>
            </div>
            <div class="card-body">
                @if($reservation->event)
                    <div class="row">
                        <div class="col-md-5 mb-3 mb-md-0">
                            @if($reservation->event->image)
                                <img src="{{ asset('storage/' . $reservation->event->image) }}" class="img-fluid event-image w-100" alt="{{ $reservation->event->name }}">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 200px; border-radius: 8px;">
                                    <i class="fas fa-calendar-alt fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <h4 class="mb-3">{{ $reservation->event->name }}</h4>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <span>{{ $reservation->event->location }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="far fa-calendar-alt text-primary me-2"></i>
                                    <span>{{ $reservation->event->date->format('F d, Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                                    <span>${{ number_format($reservation->event->price, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="text-muted small d-block">Description</label>
                                <p class="mb-0">{{ Str::limit($reservation->event->description, 150) }}</p>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('admin.events.show', $reservation->event->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt me-1"></i> View Event Details
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5>Event information not available</h5>
                        <p class="text-muted">The event associated with this reservation may have been deleted.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    <!-- Right column: Reservation Details & Status Timeline -->
    <div class="col-lg-4">
        <!-- Reservation Details -->
        <div class="card info-card reservation-details-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Reservation Details</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Reservation ID</span>
                        <span class="fw-medium">#{{ $reservation->id }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status</span>
                        <span class="status-badge status-{{ $reservation->status }} px-2 py-1">{{ ucfirst($reservation->status) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Reserved Date</span>
                        <span class="fw-medium">{{ $reservation->date->format('M d, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Reservation Made</span>
                        <span class="fw-medium">{{ $reservation->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Last Updated</span>
                        <span class="fw-medium">{{ $reservation->updated_at->format('M d, Y') }}</span>
                    </li>
                    @if($reservation->event)
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Price</span>
                            <span class="fw-medium">${{ number_format($reservation->event->price, 2) }}</span>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Days Until Event</span>
                        @if($reservation->date->isPast())
                            <span class="fw-medium text-danger">Event has passed</span>
                        @else
                            <span class="fw-medium">{{ now()->diffInDays($reservation->date, false) }} days</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Status Timeline -->
        <div class="card info-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot active"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Reservation Created</h6>
                            <p class="text-muted small mb-0">{{ $reservation->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $reservation->status == 'confirmed' ? 'active' : ($reservation->status == 'cancelled' ? 'cancelled' : '') }}"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">
                                @if($reservation->status == 'confirmed')
                                    Reservation Confirmed
                                @elseif($reservation->status == 'cancelled')
                                    Reservation Cancelled
                                @else
                                    Waiting for Confirmation
                                @endif
                            </h6>
                            <p class="text-muted small mb-0">
                                @if($reservation->status == 'confirmed' || $reservation->status == 'cancelled')
                                    {{ $reservation->updated_at->format('M d, Y - h:i A') }}
                                @else
                                    Pending
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $reservation->date->isPast() ? 'active' : '' }}"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Event Date</h6>
                            <p class="text-muted small mb-0">{{ $reservation->date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Other Reservations -->
        @if($reservation->user && $reservation->user->reservations->count() > 1)
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Other Reservations by User</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($reservation->user->reservations as $otherReservation)
                            @if($otherReservation->id != $reservation->id)
                                <a href="{{ route('admin.reservations.show', $otherReservation->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            @if($otherReservation->event)
                                                {{ Str::limit($otherReservation->event->name, 20) }}
                                            @else
                                                Unknown Event
                                            @endif
                                        </h6>
                                        <span class="status-badge status-{{ $otherReservation->status }} px-2 py-0">
                                            {{ ucfirst($otherReservation->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1 small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $otherReservation->date->format('M d, Y') }}
                                    </p>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Reservation Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reservations.update-status', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div>
                            <h5>Warning</h5>
                            <p>Are you sure you want to delete this reservation? This action <strong>cannot</strong> be undone.</p>
                        </div>
                    </div>
                </div>
                
                <p>Reservation Details:</p>
                <ul>
                    <li><strong>ID:</strong> #{{ $reservation->id }}</li>
                    <li><strong>User:</strong> {{ $reservation->user ? $reservation->user->first_name . ' ' . $reservation->user->last_name : 'Unknown' }}</li>
                    <li><strong>Event:</strong> {{ $reservation->event ? $reservation->event->name : 'Unknown' }}</li>
                    <li><strong>Date:</strong> {{ $reservation->date->format('M d, Y') }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Send Email Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendEmailModalLabel">Contact User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST"> <!-- Create a mail controller route -->
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" 
                               value="Your reservation #{{ $reservation->id }} for {{ $reservation->event ? $reservation->event->name : 'our event' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailBody" class="form-label">Message</label>
                        <textarea id="emailBody" name="message" class="form-control" rows="6" placeholder="Type your message here..."></textarea>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="includeReservationDetails" name="include_details" checked>
                        <label class="form-check-label" for="includeReservationDetails">
                            Include reservation details in email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Admin Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reservations.update-status', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="{{ $reservation->status }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note_admin_notes" class="form-label">Notes</label>
                        <textarea id="note_admin_notes" name="admin_notes" class="form-control" rows="6" placeholder="Add administrative notes about this reservation...">{{ $reservation->admin_notes ?? '' }}</textarea>
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