@extends('admin.layout')

@section('title', 'Manage Reservations')

@push('styles')
<style>
    .status-badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
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
    .table-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .search-box {
        position: relative;
    }
    .search-box .form-control {
        padding-left: 2.5rem;
    }
    .search-box .search-icon {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .table-responsive {
        min-height: 400px;
    }
    .datepicker-range {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<!-- Page header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Reservations Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservations</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
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

<!-- Reservations list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">All Reservations</h5>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>
                                @if($reservation->user)
                                    <div class="d-flex align-items-center">
                                        @php
                                            $avatar = $reservation->user->picture
                                                ? (Str::startsWith($reservation->user->picture, 'http')
                                                    ? $reservation->user->picture
                                                    : asset('storage/' . $reservation->user->picture))
                                                : asset('/assets/images/default-avatar.png');
                                        @endphp
                                        <img src="{{ $avatar }}" class="rounded-circle me-2" width="32" height="32" alt="{{ $reservation->user->first_name }}">
                                        <div>
                                            <div class="fw-medium">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</div>
                                            <div class="small text-muted">{{ $reservation->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">User not available</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->event)
                                    <div class="fw-medium">{{ $reservation->event->name }}</div>
                                    <div class="small text-muted">{{ $reservation->event->location }}</div>
                                @else
                                    <span class="text-muted">Event not available</span>
                                @endif
                            </td>
                            <td>{{ $reservation->date->format('M d, Y') }}</td>
                            <td>{{ $reservation->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ $reservation->status }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 table-actions">
                                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#statusModal{{ $reservation->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $reservation->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $reservation->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="statusModalLabel{{ $reservation->id }}">Update Reservation Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.reservations.update-status', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <p>Reservation ID: <strong>{{ $reservation->id }}</strong></p>
                                                    
                                                    @if($reservation->event)
                                                        <p>Event: <strong>{{ $reservation->event->name }}</strong></p>
                                                    @endif
                                                    
                                                    @if($reservation->user)
                                                        <p>User: <strong>{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</strong></p>
                                                    @endif
                                                    
                                                    <div class="mb-3">
                                                        <label for="status{{ $reservation->id }}" class="form-label">Status</label>
                                                        <select id="status{{ $reservation->id }}" name="status" class="form-select">
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
                                <div class="modal fade" id="deleteModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $reservation->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $reservation->id }}">Delete Reservation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this reservation?</p>
                                                <p><strong>This action cannot be undone.</strong></p>
                                                
                                                @if($reservation->event)
                                                    <p>Event: <strong>{{ $reservation->event->name }}</strong></p>
                                                @endif
                                                
                                                @if($reservation->user)
                                                    <p>User: <strong>{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</strong></p>
                                                @endif
                                                
                                                <p>Date: <strong>{{ $reservation->date->format('M d, Y') }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete Reservation</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5>No Reservations Found</h5>
                                    <p class="text-muted">No reservations match your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                @if(method_exists($reservations, 'links'))
                    <span class="text-muted">Showing {{ $reservations->firstItem() ?? 0 }} to {{ $reservations->lastItem() ?? 0 }} of {{ $reservations->total() ?? 0 }} reservations</span>
                @else
                    <span class="text-muted">Showing {{ count($reservations) }} reservations</span>
                @endif
            </div>
            <div>
                @if(method_exists($reservations, 'links'))
                    {{ $reservations->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush