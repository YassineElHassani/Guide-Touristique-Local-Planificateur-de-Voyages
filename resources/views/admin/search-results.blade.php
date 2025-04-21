@extends('admin.layout')

@section('title', 'Search Results')
@section('heading', 'Search Results')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Search</li>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.search') }}" method="GET" class="row g-3">
                        <div class="col-md-6 col-lg-8">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg" name="query" value="{{ $query }}" placeholder="Search for anything...">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select form-select-lg" name="type">
                                <option value="">All Categories</option>
                                <option value="users" {{ request('type') == 'users' ? 'selected' : '' }}>Users</option>
                                <option value="destinations" {{ request('type') == 'destinations' ? 'selected' : '' }}>Destinations</option>
                                <option value="events" {{ request('type') == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="blogs" {{ request('type') == 'blogs' ? 'selected' : '' }}>Blogs</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-lg-1">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Found results for <strong>"{{ $query }}"</strong>
            </div>
        </div>
    </div>

    <!-- Users Results -->
    @if(isset($users) && $users->count() > 0)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Users ({{ $users->count() }})</h5>
                <a href="{{ route('admin.search', ['query' => $query, 'type' => 'users']) }}" class="btn btn-sm btn-outline-primary">
                    View All User Results
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->profile->avatar ?? 'https://via.placeholder.com/32' }}" 
                                                class="rounded-circle me-2" width="32" height="32" alt="{{ $user->name }}">
                                            <div>{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'guide' ? 'bg-success' : 'bg-primary') }}">
                                            {{ ucfirst($user->role ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($user->status ?? 'inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Destinations Results -->
    @if(isset($destinations) && $destinations->count() > 0)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Destinations ({{ $destinations->count() }})</h5>
                <a href="{{ route('admin.search', ['query' => $query, 'type' => 'destinations']) }}" class="btn btn-sm btn-outline-primary">
                    View All Destination Results
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($destinations as $destination)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($destination->image))
                                                <img src="{{ asset('storage/'.$destination->image) }}" 
                                                    class="rounded me-2" width="40" height="40" style="object-fit: cover;" alt="{{ $destination->name }}">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                                </div>
                                            @endif
                                            <div>{{ $destination->name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $destination->category }}</span>
                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $destination->address }}</td>
                                    <td>
                                        <a href="{{ route('admin.destinations.show', $destination->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Events Results -->
    @if(isset($events) && $events->count() > 0)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Events ({{ $events->count() }})</h5>
                <a href="{{ route('admin.search', ['query' => $query, 'type' => 'events']) }}" class="btn btn-sm btn-outline-primary">
                    View All Event Results
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($event->image))
                                                <img src="{{ asset('storage/'.$event->image) }}" 
                                                    class="rounded me-2" width="40" height="40" style="object-fit: cover;" alt="{{ $event->name }}">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-calendar-alt text-muted"></i>
                                                </div>
                                            @endif
                                            <div>{{ $event->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>${{ number_format($event->price, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Blogs Results -->
    @if(isset($blogs) && $blogs->count() > 0)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Blog Posts ({{ $blogs->count() }})</h5>
                <a href="{{ route('admin.search', ['query' => $query, 'type' => 'blogs']) }}" class="btn btn-sm btn-outline-primary">
                    View All Blog Results
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($blog->image))
                                                <img src="{{ asset('storage/'.$blog->image) }}" 
                                                    class="rounded me-2" width="40" height="40" style="object-fit: cover;" alt="{{ $blog->title }}">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-blog text-muted"></i>
                                                </div>
                                            @endif
                                            <div>{{ $blog->title }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $blog->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $blog->category ?? 'Uncategorized' }}</td>
                                    <td>
                                        <span class="badge {{ $blog->published ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $blog->published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- No Results -->
    @if((!isset($users) || $users->count() == 0) && 
        (!isset($destinations) || $destinations->count() == 0) && 
        (!isset($events) || $events->count() == 0) && 
        (!isset($blogs) || $blogs->count() == 0))
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4>No Results Found</h4>
                <p class="text-muted">We couldn't find any results matching your search criteria.</p>
                <p>Try adjusting your search terms or browse content using the navigation menu.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.dashboard.index') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection