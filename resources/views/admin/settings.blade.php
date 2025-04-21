@extends('admin.layout')

@section('title', 'Site Settings')
@section('heading', 'Site Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Settings Menu</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#general-settings" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="fas fa-cog fa-fw me-2"></i> General Settings
                        </a>
                        <a href="#contact-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-envelope fa-fw me-2"></i> Contact Information
                        </a>
                        <a href="#social-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-share-alt fa-fw me-2"></i> Social Media
                        </a>
                        <a href="#analytics-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-chart-line fa-fw me-2"></i> Analytics
                        </a>
                        <a href="#backup-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-database fa-fw me-2"></i> Backup & Maintenance
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-sync-alt"></i> Clear Cache
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-database"></i> Export Database
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="tab-content">
                <!-- General Settings Tab -->
                <div class="tab-pane fade show active" id="general-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">General Site Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                        id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Guide Touristique Local') }}">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Site Description</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                        id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description'] ?? 'Your local guide for discovering amazing destinations and planning unforgettable trips.') }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="timezone" class="form-label">Timezone</label>
                                        <select class="form-select @error('timezone') is-invalid @enderror" id="timezone" name="timezone">
                                            @php
                                                $timezones = timezone_identifiers_list();
                                                $current_timezone = old('timezone', $settings['timezone'] ?? 'UTC');
                                            @endphp
                                            @foreach($timezones as $timezone)
                                                <option value="{{ $timezone }}" {{ $current_timezone == $timezone ? 'selected' : '' }}>
                                                    {{ $timezone }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="date_format" class="form-label">Date Format</label>
                                        <select class="form-select @error('date_format') is-invalid @enderror" id="date_format" name="date_format">
                                            @php
                                                $date_formats = [
                                                    'Y-m-d' => date('Y-m-d'),
                                                    'm/d/Y' => date('m/d/Y'),
                                                    'd/m/Y' => date('d/m/Y'),
                                                    'M d, Y' => date('M d, Y'),
                                                    'd M Y' => date('d M Y')
                                                ];
                                                $current_format = old('date_format', $settings['date_format'] ?? 'Y-m-d');
                                            @endphp
                                            @foreach($date_formats as $format => $example)
                                                <option value="{{ $format }}" {{ $current_format == $format ? 'selected' : '' }}>
                                                    {{ $example }} ({{ $format }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('date_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="items_per_page" class="form-label">Items Per Page</label>
                                    <input type="number" class="form-control @error('items_per_page') is-invalid @enderror" 
                                        id="items_per_page" name="items_per_page" value="{{ old('items_per_page', $settings['items_per_page'] ?? 15) }}" min="5" max="100">
                                    <div class="form-text">Number of items to display per page in listings.</div>
                                    @error('items_per_page')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1"
                                            {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">Maintenance Mode</label>
                                    </div>
                                    <div class="form-text">When enabled, the site will be inaccessible to regular users.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save General Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Settings Tab -->
                <div class="tab-pane fade" id="contact-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                        id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'contact@example.com') }}">
                                    <div class="form-text">Main email address displayed on the contact page.</div>
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                        id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+1 (555) 123-4567') }}">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Office Address</label>
                                    <textarea class="form-control @error('contact_address') is-invalid @enderror" 
                                        id="contact_address" name="contact_address" rows="3">{{ old('contact_address', $settings['contact_address'] ?? '123 Travel Street, Tourism City, TC 12345') }}</textarea>
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="business_hours" class="form-label">Business Hours</label>
                                    <textarea class="form-control @error('business_hours') is-invalid @enderror" 
                                        id="business_hours" name="business_hours" rows="3">{{ old('business_hours', $settings['business_hours'] ?? 'Monday - Friday: 9:00 AM - 5:00 PM
Saturday: 10:00 AM - 3:00 PM
Sunday: Closed') }}</textarea>
                                    @error('business_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="show_contact_form" name="show_contact_form" value="1"
                                            {{ old('show_contact_form', $settings['show_contact_form'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_contact_form">Show Contact Form</label>
                                    </div>
                                    <div class="form-text">Enable or disable the contact form on the contact page.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Contact Information
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Tab -->
                <div class="tab-pane fade" id="social-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Social Media Links</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">
                                        <i class="fab fa-facebook text-primary me-2"></i> Facebook
                                    </label>
                                    <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                        id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/yourpage">
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">
                                        <i class="fab fa-twitter text-info me-2"></i> Twitter
                                    </label>
                                    <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                        id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" placeholder="https://twitter.com/yourhandle">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">
                                        <i class="fab fa-instagram text-danger me-2"></i> Instagram
                                    </label>
                                    <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                        id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/yourprofile">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">
                                        <i class="fab fa-youtube text-danger me-2"></i> YouTube
                                    </label>
                                    <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                        id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/c/yourchannel">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="linkedin_url" class="form-label">
                                        <i class="fab fa-linkedin text-primary me-2"></i> LinkedIn
                                    </label>
                                    <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                        id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" placeholder="https://linkedin.com/company/yourcompany">
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="show_social_icons" name="show_social_icons" value="1"
                                            {{ old('show_social_icons', $settings['show_social_icons'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_social_icons">Show Social Icons in Footer</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Social Media Links
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Analytics Tab -->
                <div class="tab-pane fade" id="analytics-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Analytics Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="google_analytics_id" class="form-label">Google Analytics Tracking ID</label>
                                    <input type="text" class="form-control @error('google_analytics_id') is-invalid @enderror" 
                                        id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="UA-XXXXXXXXX-X or G-XXXXXXXXXX">
                                    <div class="form-text">Enter your Google Analytics tracking ID to enable website analytics.</div>
                                    @error('google_analytics_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="track_logged_in_users" name="track_logged_in_users" value="1"
                                            {{ old('track_logged_in_users', $settings['track_logged_in_users'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="track_logged_in_users">Track Logged-in Users</label>
                                    </div>
                                    <div class="form-text">Enable tracking for authenticated users.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_site_analytics" name="enable_site_analytics" value="1"
                                            {{ old('enable_site_analytics', $settings['enable_site_analytics'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_site_analytics">Enable Internal Analytics</label>
                                    </div>
                                    <div class="form-text">Collect internal site usage data for the admin dashboard.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Analytics Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Backup & Maintenance Tab -->
                <div class="tab-pane fade" id="backup-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Backup & Maintenance</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6>Database Backup</h6>
                                <p class="text-muted">Configure automatic database backups and download recent backups.</p>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary w-100">
                                            <i class="fas fa-download"></i> Download Latest Backup
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success w-100">
                                            <i class="fas fa-database"></i> Create New Backup
                                        </button>
                                    </div>
                                </div>
                                
                                <form action="{{ route('admin.settings.update') }}" method="POST" class="mb-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="backup_frequency" class="form-label">Automatic Backup Frequency</label>
                                        <select class="form-select" id="backup_frequency" name="backup_frequency">
                                            <option value="daily" {{ ($settings['backup_frequency'] ?? 'weekly') == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="weekly" {{ ($settings['backup_frequency'] ?? 'weekly') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="monthly" {{ ($settings['backup_frequency'] ?? 'weekly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="never" {{ ($settings['backup_frequency'] ?? 'weekly') == 'never' ? 'selected' : '' }}>Never</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="backup_retention" class="form-label">Backup Retention (days)</label>
                                        <input type="number" class="form-control" id="backup_retention" name="backup_retention" 
                                            value="{{ $settings['backup_retention'] ?? 30 }}" min="1" max="365">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Backup Settings
                                    </button>
                                </form>
                            </div>
                            
                            <hr>
                            
                            <div class="mb-4">
                                <h6>System Maintenance</h6>
                                <p class="text-muted">Perform maintenance tasks to keep the system running smoothly.</p>
                                
                                <div class="row mb-3 g-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-broom"></i> Clear Cache
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-trash-alt"></i> Clear Temporary Files
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-sync-alt"></i> Optimize Database
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-lock"></i> Reset File Permissions
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div>
                                <h6 class="text-danger">Danger Zone</h6>
                                <p class="text-muted">These actions are potentially destructive and should be used with caution.</p>
                                
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetSystemModal">
                                    <i class="fas fa-exclamation-triangle"></i> Reset System to Default
                                </button>
                                
                                <!-- Reset System Modal -->
                                <div class="modal fade" id="resetSystemModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle"></i> Confirm System Reset
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Warning:</strong> This action will reset all system settings to their default values.</p>
                                                <p>This will not affect user accounts, destinations, or other content data, but all custom settings will be lost.</p>
                                                <p class="text-danger fw-bold">This action cannot be undone.</p>
                                                
                                                <div class="mt-3">
                                                    <label for="resetConfirmation" class="form-label">Type "RESET" to confirm:</label>
                                                    <input type="text" class="form-control" id="resetConfirmation" placeholder="RESET">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" id="confirmResetBtn" disabled>
                                                    Reset System
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle reset confirmation
        const resetConfirmationInput = document.getElementById('resetConfirmation');
        const confirmResetBtn = document.getElementById('confirmResetBtn');
        
        if (resetConfirmationInput && confirmResetBtn) {
            resetConfirmationInput.addEventListener('input', function() {
                confirmResetBtn.disabled = this.value !== 'RESET';
            });
        }
        
        // Handle tab activation based on URL hash
        const hash = window.location.hash;
        if (hash) {
            const tab = document.querySelector(`a[href="${hash}"]`);
            if (tab) {
                tab.click();
            }
        }
        
        // Update URL hash when tab changes
        const tabLinks = document.querySelectorAll('a[data-bs-toggle="list"]');
        tabLinks.forEach(tabLink => {
            tabLink.addEventListener('shown.bs.tab', function (e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });
    });
</script>
@endpush