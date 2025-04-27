@extends('layouts.template')

@section('title', 'Account Warning')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning fa-5x"></i>
                    </div>
                    <h2 class="mb-4">Account Inactive</h2>
                    <p class="lead mb-4">Your account is currently inactive. This could be due to one of the following reasons:</p>
                    
                    <div class="alert alert-light text-start mb-4">
                        <ul class="mb-0">
                            <li>Your account is pending approval by our administrators</li>
                            <li>Your account has been temporarily suspended</li>
                            <li>Your subscription has expired</li>
                        </ul>
                    </div>
                    
                    <p class="mb-4">If you believe this is an error or would like to reactivate your account, please contact our support team.</p>
                    
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-envelope me-2"></i> Contact Support
                        </a>
                        <a href="{{ route('index') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-home me-2"></i> Return Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection