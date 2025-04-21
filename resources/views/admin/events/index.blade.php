@extends('admin.layout')

@section('title', 'Event Management')
@section('heading', 'Event Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Events</li>
@endsection

@section('actions')
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Event
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Events</h5>
            <form action="{{ route('admin.search') }}" method="GET" class="me-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search events..." name="query">
                    <input type="hidden" name="type" value="events">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->date->format('M d, Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>${{ number_format($event->price, 2) }}</td>
                                <td>{{ $event->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $event->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the event <strong>{{ $event->name }}</strong>?</p>
                                                    <p class="text-danger">This action cannot be undone.</p>
                                                    
                                                    @php
                                                        $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->count();
                                                    @endphp
                                                    
                                                    @if($reservationsCount > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            This event has <strong>{{ $reservationsCount }}</strong> active reservations.
                                                            All reservations must be canceled before deleting.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" {{ $reservationsCount > 0 ? 'disabled' : '' }}>
                                                            Delete Event
                                                        </button>
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
                                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                        <h5>No Events Found</h5>
                                        <p class="text-muted">There are no events in the system yet.</p>
                                        <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Add Event
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($events) && method_exists($events, 'links'))
            <div class="card-footer d-flex justify-content-center">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection