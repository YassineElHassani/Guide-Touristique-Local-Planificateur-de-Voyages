@extends('client.dashboard')

@section('dashboard-title', 'My Profile')
@section('dashboard-breadcrumb', 'Profile')

@section('dashboard-actions')
<a href="{{ route('client.profile.edit') }}" class="btn btn-primary">
    <i class="fas fa-edit me-1"></i> Edit Profile
</a>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Profile Summary Card -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="mb-4">
                    @php
                        $avatar = $user->picture
                            ? (Str::startsWith($user->picture, 'http')
                                ? $user->picture
                                : asset('storage/' . $user->picture))
                            : asset('/assets/images/default-avatar.png');
                    @endphp
                    <img src="{{ $avatar }}" alt="{{ $user->first_name }}" class="rounded-circle profile-avatar mb-3">
                    <h4 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h4>
                    <p class="text-muted mb-0">{{ $user->role ? ucfirst($user->role) : 'Traveler' }}</p>
                </div>
                
                <div class="profile-stats mb-4">
                    <div class="row g-0">
                        <div class="col border-end">
                            <div class="p-3">
                                <h5>{{ $user->reservations->count() }}</h5>
                                <p class="small text-muted mb-0">Reservations</p>
                            </div>
                        </div>
                        <div class="col border-end">
                            <div class="p-3">
                                <h5>{{ $user->reviews->count() }}</h5>
                                <p class="small text-muted mb-0">Reviews</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3">
                                <h5>{{ $user->favorites->count() }}</h5>
                                <p class="small text-muted mb-0">Favorites</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                        <a href="{{ route('client.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                    <a href="{{ route('client.reservations.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-calendar-check me-2"></i> View Reservations
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profile Details Card -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <p class="text-muted mb-1 small">Full Name</p>
                        <p class="mb-0 fs-5">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small">Email Address</p>
                        <p class="mb-0 fs-5">{{ $user->email }}</p>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <p class="text-muted mb-1 small">Phone Number</p>
                        <p class="mb-0 fs-5">{{ $user->phone ?: 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small">Date of Birth</p>
                        <p class="mb-0 fs-5">{{ $user->birthday ? date('F d, Y', strtotime($user->birthday)) : 'Not provided' }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small">Gender</p>
                        <p class="mb-0 fs-5">{{ $user->gender ? ucfirst($user->gender) : 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small">Member Since</p>
                        <p class="mb-0 fs-5">{{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6>Account Status</h6>
                        <p class="mb-0">
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }} p-2">
                                <i class="fas fa-{{ $user->status === 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                {{ ucfirst($user->status ?: 'Active') }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('client.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> Update Information
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @if($user->reservations->count() > 0)
                        @foreach($user->reservations->sortByDesc('created_at')->take(3) as $reservation)
                            <div class="list-group-item p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-3 me-3">
                                        <i class="fas fa-calendar-check text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Reservation: {{ $reservation->event->name ?? 'Event' }}</h6>
                                        <p class="small text-muted mb-0">
                                            <i class="far fa-clock me-1"></i> {{ $reservation->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <a href="{{ route('client.reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-primary ms-auto">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                            <h5>No Reservations Yet</h5>
                            <p class="text-muted mb-3">Explore events and book your next adventure!</p>
                            <a href="{{ route('client.events.index') }}" class="btn btn-primary">
                                <i class="fas fa-ticket-alt me-1"></i> Browse Events
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 5px solid rgba(var(--bs-primary-rgb), 0.1);
    }
    
    .profile-stats {
        background-color: rgba(var(--bs-light-rgb), 0.5);
        border-radius: 0.5rem;
    }
    
    .profile-stats h5 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
</style>
@endpush