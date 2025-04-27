@extends('guide.dashboard')

@section('dashboard-title', 'Create New Event')
@section('dashboard-breadcrumb', 'Create Event')

@section('dashboard-actions')
    <a href="{{ route('guide.events.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-1"></i> Back to Events
    </a>
@endsection

@section('dashboard-content')
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('guide.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Event Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Event Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Event Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <select class="form-select @error('location') is-invalid @enderror" id="location"
                                    name="location" required>
                                    <option value="">Select a location</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->name }}"
                                            {{ old('location') == $destination->name ? 'selected' : '' }}
                                            data-coordinates="{{ $destination->coordinates }}">
                                            {{ $destination->name }} - {{ $destination->address }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price ($)</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                    required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Event Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                <div class="form-text">Upload an image for this event. Maximum size: 2MB.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2"
                        onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                previewContainer.classList.add('d-none');
            }
        });
    </script>
@endpush
