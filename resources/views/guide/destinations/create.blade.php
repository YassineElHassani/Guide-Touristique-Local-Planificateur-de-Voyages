@extends('guide.dashboard')

@section('dashboard-title', 'Create New Destination')
@section('dashboard-breadcrumb', 'Create Destination')

@section('dashboard-actions')
    <a href="{{ route('guide.destinations.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-1"></i> Back to Destinations
    </a>
@endsection

@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('guide.destinations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <!-- Destination Details Column -->
                    <div class="col-md-8">
                        <h5 class="mb-3">Destination Details</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Destination Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                    id="location" name="location" value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">Select a category</option>
                                    @foreach(\App\Models\categories::where('user_id', Auth::id())->get() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                id="address" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" 
                                    id="latitude" name="latitude" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror" 
                                    id="longitude" name="longitude" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="highlights" class="form-label">Highlights</label>
                            <textarea class="form-control @error('highlights') is-invalid @enderror" 
                                id="highlights" name="highlights" rows="3">{{ old('highlights') }}</textarea>
                            <div class="form-text">List key attractions or features of this destination.</div>
                            @error('highlights')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tips" class="form-label">Travel Tips</label>
                            <textarea class="form-control @error('tips') is-invalid @enderror" 
                                id="tips" name="tips" rows="3">{{ old('tips') }}</textarea>
                            <div class="form-text">Provide helpful tips for visitors to this destination.</div>
                            @error('tips')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Media and Settings Column -->
                    <div class="col-md-4">
                        <h5 class="mb-3">Media & Settings</h5>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Featured Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                        id="image" name="image" accept="image/*">
                                    <div class="form-text">Recommended size: 1200x800px, max 2MB</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-3 text-center d-none" id="image-preview-container">
                                        <img id="image-preview" src="#" alt="Destination Image Preview" class="img-fluid rounded">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="gallery" class="form-label">Additional Images (Optional)</label>
                                    <input type="file" class="form-control @error('gallery') is-invalid @enderror" 
                                        id="gallery" name="gallery[]" accept="image/*" multiple>
                                    <div class="form-text">You can select multiple images (max 5)</div>
                                    @error('gallery')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Destination Settings</h6>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                        {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Feature this destination</label>
                                    <div class="form-text">Featured destinations appear on the homepage</div>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                    <div class="form-text">Inactive destinations won't be visible to users</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Additional Information</h6>
                                
                                <div class="mb-3">
                                    <label for="best_time_to_visit" class="form-label">Best Time to Visit</label>
                                    <input type="text" class="form-control" id="best_time_to_visit" name="best_time_to_visit" 
                                        value="{{ old('best_time_to_visit') }}" placeholder="e.g. Spring, Summer">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="ideal_duration" class="form-label">Ideal Duration</label>
                                    <input type="text" class="form-control" id="ideal_duration" name="ideal_duration" 
                                        value="{{ old('ideal_duration') }}" placeholder="e.g. 2-3 days">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" 
                                        value="{{ old('tags') }}" placeholder="e.g. beach, mountain, historic">
                                    <div class="form-text">Separate tags with commas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Destination</button>
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
