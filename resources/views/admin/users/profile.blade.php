@extends('admin.layout')

@section('title', 'User Profile')

@section('content')
    <div class="row">
        <div class="col-xl-4">
            <!-- User Profile -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile Information</h5>
                    <div>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center mb-4">
                        @php
                            $avatar = $user->picture
                                ? (Str::startsWith($user->picture, 'http')
                                    ? $user->picture
                                    : asset('storage/' . $user->picture))
                                : asset('/assets/images/default-avatar.png');
                        @endphp
                        <img src="{{ $avatar }}" alt="{{ $user->first_name }}"
                            class="rounded-circle img-thumbnail mb-3" width="150">
                        <h5 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                        <div>
                            <span
                                class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'guide' ? 'bg-success' : 'bg-primary') }}">
                                {{ ucfirst($user->role ?? 'N/A') }}
                            </span>
                            <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($user->status ?? 'inactive') }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <!-- User Details -->
                    <div class="user-details">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                {{ $user->email }}
                            </div>
                        </div>

                        @if ($profile)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ $user->phone ?? 'N/A' }}
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Member Since</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                {{ $user->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Activity Tabs -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="userActivity" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="reservations-tab" data-bs-toggle="tab" href="#reservations"
                                role="tab">
                                Reservations <span class="badge bg-primary">{{ $reservations->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab">
                                Reviews <span class="badge bg-primary">{{ $reviews->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="blogs-tab" data-bs-toggle="tab" href="#blogs" role="tab">
                                Blogs <span class="badge bg-primary">{{ $blogs->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userActivityContent">
                        <!-- Reservations Tab -->
                        <div class="tab-pane fade show active" id="reservations" role="tabpanel">
                            @if ($reservations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Event</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Booked On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reservations as $reservation)
                                                <tr>
                                                    <td>{{ $reservation->id }}</td>
                                                    <td>
                                                        @if ($reservation->event)
                                                            <a
                                                                href="{{ route('admin.events.show', $reservation->event->id) }}">
                                                                {{ $reservation->event->name }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Deleted Event</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $reservation->date ? \Carbon\Carbon::parse($reservation->date)->format('M d, Y') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $reservation->status == 'confirmed'
                                                                ? 'bg-success'
                                                                : ($reservation->status == 'pending'
                                                                    ? 'bg-warning'
                                                                    : ($reservation->status == 'cancelled'
                                                                        ? 'bg-danger'
                                                                        : 'bg-secondary')) }}">
                                                            {{ ucfirst($reservation->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $reservation->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                    <h5>No Reservations</h5>
                                    <p class="text-muted">This user hasn't made any reservations yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            @if ($reviews->count() > 0)
                                <div class="row">
                                    @foreach ($reviews as $review)
                                        <div class="col-lg-6 mb-4">
                                            <div class="card border h-100">
                                                <div
                                                    class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <div>
                                                        @if ($review->destination)
                                                            <a
                                                                href="{{ route('admin.destinations.show', $review->destination->id) }}">
                                                                {{ $review->destination->name }}
                                                            </a>
                                                        @elseif($review->event)
                                                            <a
                                                                href="{{ route('admin.events.show', $review->event->id) }}">
                                                                {{ $review->event->name }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Deleted Item</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-warning">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">{{ $review->comment }}</p>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between text-muted">
                                                    <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                    <div>
                                                        <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5>No Reviews</h5>
                                    <p class="text-muted">This user hasn't left any reviews yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Blogs Tab -->
                        <div class="tab-pane fade" id="blogs" role="tabpanel">
                            @if ($blogs->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Views</th>
                                                <th>Published On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($blogs as $blog)
                                                <tr>
                                                    <td>{{ $blog->title }}</td>
                                                    <td>{{ $blog->category ?? 'Uncategorized' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $blog->published ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $blog->published ? 'Published' : 'Draft' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $blog->views ?? 0 }}</td>
                                                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.blogs.show', $blog->slug) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                                    <h5>No Blog Posts</h5>
                                    <p class="text-muted">This user hasn't written any blog posts yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
