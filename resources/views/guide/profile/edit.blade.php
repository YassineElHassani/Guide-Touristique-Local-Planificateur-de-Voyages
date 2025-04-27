@extends('client.dashboard')

@section('dashboard-title', 'Edit Profile')
@section('dashboard-breadcrumb', 'Edit Profile')

@section('dashboard-actions')
<a href="{{ route('guide.profile.show') }}" class="btn btn-outline-primary">
    <i class="fas fa-arrow-left me-1"></i> Back to Profile
</a>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Profile Information Form -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0">Profile Information</h5>
                <p class="text-muted small mb-0">Update your personal details and profile picture</p>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="profile_info">
                    
                    <!-- Profile Picture -->
                    <div class="mb-4 text-center">
                        @php
                            $avatar = $user->picture
                                ? (Str::startsWith($user->picture, 'http')
                                    ? $user->picture
                                    : asset('storage/' . $user->picture))
                                : asset('/assets/images/default-avatar.png');
                        @endphp
                        
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $avatar }}" alt="{{ $user->first_name }}" class="rounded-circle profile-avatar" id="profile-preview">
                            <label for="picture" class="position-absolute bottom-0 end-0 btn btn-sm btn-primary rounded-circle">
                                <i class="fas fa-camera"></i>
                            </label>
                        </div>
                        
                        <div class="mb-3">
                            <input type="file" name="picture" id="picture" class="form-control @error('picture') is-invalid @enderror" accept="image/*" style="display: none;">
                            <small class="text-muted d-block">Click on the camera icon to change your profile picture</small>
                            
                            @error('picture')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <!-- First Name -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <!-- Email -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <!-- Gender -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Birthday -->
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday ? date('Y-m-d', strtotime($user->birthday)) : '') }}">
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('guide.profile.show') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Change Password Form -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0">Change Password</h5>
                <p class="text-muted small mb-0">Update your password for better security</p>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="password">
                    <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                    <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <input type="hidden" name="gender" value="{{ $user->gender }}">
                    <input type="hidden" name="birthday" value="{{ $user->birthday }}">
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Profile Tips -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0">Tips for Your Profile</h5>
            </div>
            
            <div class="card-body p-4">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary-subtle rounded-circle p-2 me-3">
                            <i class="fas fa-image text-primary"></i>
                        </div>
                        <h6 class="mb-0">Profile Picture</h6>
                    </div>
                    <p class="text-muted small mb-0">Add a clear photo of yourself to personalize your profile.</p>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary-subtle rounded-circle p-2 me-3">
                            <i class="fas fa-shield-alt text-primary"></i>
                        </div>
                        <h6 class="mb-0">Strong Password</h6>
                    </div>
                    <p class="text-muted small mb-0">Use a unique password with at least 8 characters including letters, numbers, and symbols.</p>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary-subtle rounded-circle p-2 me-3">
                            <i class="fas fa-phone-alt text-primary"></i>
                        </div>
                        <h6 class="mb-0">Contact Information</h6>
                    </div>
                    <p class="text-muted small mb-0">Keep your phone number up to date for important notifications about your bookings.</p>
                </div>
                
                <div class="mb-0">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary-subtle rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation-circle text-primary"></i>
                        </div>
                        <h6 class="mb-0">Privacy Matters</h6>
                    </div>
                    <p class="text-muted small mb-0">Your personal information is protected and only used to enhance your travel experience.</p>
                </div>
            </div>
        </div>
        
        <!-- Account Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0">Account Actions</h5>
            </div>
            
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('client.reservations.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar-check me-2"></i> View Reservations
                    </a>
                    
                    <a href="{{ route('client.favorites') }}" class="btn btn-outline-primary">
                        <i class="fas fa-heart me-2"></i> View Favorites
                    </a>
                    
                    <a href="{{ route('client.reviews') }}" class="btn btn-outline-primary">
                        <i class="fas fa-star me-2"></i> View Reviews
                    </a>
                    
                    <hr class="my-3">
                    
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle profile picture preview
        const pictureInput = document.getElementById('picture');
        const profilePreview = document.getElementById('profile-preview');
        
        pictureInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Trigger file input when clicking on camera icon
        document.querySelector('label[for="picture"]').addEventListener('click', function(e) {
            e.preventDefault();
            pictureInput.click();
        });
    });
</script>
@endpush