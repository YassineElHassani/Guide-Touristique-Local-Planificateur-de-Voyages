@extends('layouts.template')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="fw-bold mb-0">Welcome Back</h4>
                    <p class="mb-0">Sign in to your account</p>
                </div>
                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label">Password</label>
                                <a href="#" class="text-decoration-none small">Forgot password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-4">Sign In</button>
                        
                        <div class="text-center">
                            <p class="mb-4">Or sign in with</p>
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <a href="{{ route('google.login') }}" class="btn btn-outline-danger rounded-circle">
                                    <i class="fab fa-google"></i>
                                </a>
                            </div>
                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endpush