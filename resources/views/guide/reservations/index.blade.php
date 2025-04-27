@extends('guide.dashboard')

@section('dashboard-title', 'Manage Reservations')
@section('dashboard-breadcrumb', 'Reservations')

@section('dashboard-content')
    <!-- Reservation Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-check text-info fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total</h6>
                            <h3 class="mb-0">{{ $reservations->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-clock text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Confirmed</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'confirmed')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-times-circle text-danger fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Cancelled</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">All Reservations</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Guests</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <td>
                                    @if($reservation->event)
                                        <a href="{{ route('guide.events.show', $reservation->event->id) }}" class="text-decoration-none">
                                            {{ $reservation->event->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Unknown Event</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                                <td>{{ $reservation->guests }}</td>
                                <td>${{ number_format($reservation->total_price, 2) }}</td>
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
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5>No Reservations Found</h5>
                                        <p class="text-muted">There are no reservations matching your filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reservations->count() > 0 && $reservations instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-0 py-3">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
@endsection
