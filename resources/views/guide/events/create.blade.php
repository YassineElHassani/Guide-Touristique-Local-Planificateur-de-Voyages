@extends('guide.dashboard')

@section('dashboard-title', 'Create New Event')

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('guide.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row g-4">
        <!-- Event Basic Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Event Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            <div class="form-text">Provide a detailed description of the event, including what participants can expect.</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="time" class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="duration" class="form-label">Duration (hours) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', 2) }}" min="0.5" step="0.5" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Maximum Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', 10) }}" min="1" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">-- Select Category --</option>
                                <option value="Cultural Tour" {{ old('category') == 'Cultural Tour' ? 'selected' : '' }}>Cultural Tour</option>
                                <option value="Adventure" {{ old('category') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                <option value="Food & Drink" {{ old('category') == 'Food & Drink' ? 'selected' : '' }}>Food & Drink</option>
                                <option value="Nature" {{ old('category') == 'Nature' ? 'selected' : '' }}>Nature</option>
                                <option value="History" {{ old('category') == 'History' ? 'selected' : '' }}>History</option>
                                <option value="Art & Museums" {{ old('category') == 'Art & Museums' ? 'selected' : '' }}>Art & Museums</option>
                                <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Location Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Location Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="location" class="form-label">Location Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                            <div class="form-text">E.g. Eiffel Tower, Central Park, etc.</div>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="meeting_point" class="form-label">Meeting Point Instructions</label>
                            <textarea class="form-control" id="meeting_point" name="meeting_point" rows="3">{{ old('meeting_point') }}</textarea>
                            <div class="form-text">Provide detailed instructions about where participants should meet.</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Additional Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="what_included" class="form-label">What's Included</label>
                            <textarea class="form-control" id="what_included" name="what_included" rows="3">{{ old('what_included') }}</textarea>
                            <div class="form-text">List what is included in the event price (e.g. equipment, meals, etc.)</div>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="what_to_bring" class="form-label">What to Bring</label>
                            <textarea class="form-control" id="what_to_bring" name="what_to_bring" rows="3">{{ old('what_to_bring') }}</textarea>
                            <div class="form-text">List what participants should bring to the event</div>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Features</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="family_friendly" name="features[]" value="family_friendly" {{ is_array(old('features')) && in_array('family_friendly', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="family_friendly">Family Friendly</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accessible" name="features[]" value="accessible" {{ is_array(old('features')) && in_array('accessible', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="accessible">Accessible</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pet_friendly" name="features[]" value="pet_friendly" {{ is_array(old('features')) && in_array('pet_friendly', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pet_friendly">Pet Friendly</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="private" name="features[]" value="private" {{ is_array(old('features')) && in_array('private', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="private">Private</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="transportation" name="features[]" value="transportation" {{ is_array(old('features')) && in_array('transportation', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="transportation">Transportation Included</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="meals" name="features[]" value="meals" {{ is_array(old('features')) && in_array('meals', old('features')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="meals">Meals Included</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Images Upload -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Images</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
                        <div class="form-text">Recommended size: 1200x800 pixels</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="additional_images" class="form-label">Additional Images</label>
                        <input type="file" class="form-control" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                        <div class="form-text">You can select multiple images (max: 5)</div>
                    </div>
                </div>
            </div>
            
            <!-- Cancellation Policy -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Cancellation Policy</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <select class="form-select" id="cancellation_policy" name="cancellation_policy">
                            <option value="flexible" {{ old('cancellation_policy') == 'flexible' ? 'selected' : '' }}>Flexible (full refund up to 24 hours before)</option>
                            <option value="moderate" {{ old('cancellation_policy') == 'moderate' ? 'selected' : '' }}>Moderate (full refund up to 5 days before)</option>
                            <option value="strict" {{ old('cancellation_policy') == 'strict' ? 'selected' : '' }}>Strict (no refunds)</option>
                            <option value="custom" {{ old('cancellation_policy') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    
                    <div id="customPolicySection" class="d-none">
                        <div class="mb-3">
                            <label for="custom_policy" class="form-label">Custom Policy</label>
                            <textarea class="form-control" id="custom_policy" name="custom_policy" rows="3">{{ old('custom_policy') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
                    </div>
                </div>
            </div>
            
            <!-- Publish Options -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Publish Options</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="publish" name="publish" value="1" {{ old('publish') ? 'checked' : '' }}>
                            <label class="form-check-label" for="publish">Publish Event</label>
                        </div>
                        <div class="form-text">If unchecked, the event will be saved as a draft.</div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Create Event</button>
                        <a href="{{ route('guide.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle custom cancellation policy section
        const cancellationPolicySelect = document.getElementById('cancellation_policy');
        const customPolicySection = document.getElementById('customPolicySection');
        
        function toggleCustomPolicy() {
            if (cancellationPolicySelect.value === 'custom') {
                customPolicySection.classList.remove('d-none');
            } else {
                customPolicySection.classList.add('d-none');
            }
        }
        
        cancellationPolicySelect.addEventListener('change', toggleCustomPolicy);
        toggleCustomPolicy(); // Initial state
    });
</script>
@endpush