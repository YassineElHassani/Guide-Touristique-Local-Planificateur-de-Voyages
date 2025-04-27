@extends('guide.dashboard')

@section('dashboard-title', 'Edit Event')
@section('dashboard-breadcrumb', 'Edit Event')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Event
        </a>
    </div>
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
            <form action="{{ route('guide.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Event Details Column -->
                    <div class="col-md-8">
                        <h5 class="mb-3">Event Details</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $event->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                                    <option value="">Select a location</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->name }}" 
                                            {{ old('location', $event->location) == $destination->name ? 'selected' : '' }}
                                            data-coordinates="{{ $destination->coordinates }}">
                                            {{ $destination->name }} - {{ $destination->address }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                    id="date" name="date" value="{{ old('date', $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d') : '') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" 
                                id="price" name="price" value="{{ old('price', $event->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @php
                                $reservationsCount = \App\Models\reservations::where('event_id', $event->id)
                                    ->whereIn('status', ['confirmed', 'pending'])
                                    ->count();
                            @endphp
                            
                            @if($reservationsCount > 0)
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    This event already has {{ $reservationsCount }} reservation(s)
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Media Column -->
                    <div class="col-md-4">
                        <h5 class="mb-3">Media</h5>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Event Image</label>
                                    
                                    @if($event->image)
                                        <div class="mb-3 text-center">
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" 
                                                class="img-fluid rounded" style="max-height: 200px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                                <label class="form-check-label" for="remove_image">
                                                    Remove current image
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                        id="image" name="image" accept="image/*">
                                    <div class="form-text">Recommended size: 1200x800px, max 2MB</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-3 text-center d-none" id="image-preview-container">
                                        <img id="image-preview" src="#" alt="Event Image Preview" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Danger Zone</h6>
                                <p class="text-muted small">Be careful with these actions. They cannot be undone.</p>
                                
                                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i> Delete Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>
    
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
    
    // Handle remove image checkbox
    const removeImageCheckbox = document.getElementById('remove_image');
    const imageInput = document.getElementById('image');
    
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                imageInput.disabled = true;
            } else {
                imageInput.disabled = false;
            }
        });
    }
</script>
@endpush
