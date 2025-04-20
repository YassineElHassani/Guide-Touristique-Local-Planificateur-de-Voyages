@extends('admin.dashboard')

@section('dashboard-title', 'Admin Overview')

@section('dashboard-actions')
<div class="d-flex gap-2">
    <button class="btn btn-outline-secondary">
        <i class="fas fa-download me-1"></i> Export
    </button>
    <button class="btn btn-danger">
        <i class="fas fa-cog me-1"></i> Settings
    </button>
</div>
@endsection

@section('dashboard-content')
<!-- Stats Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-users text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Users</h6>
                        <h3 class="mb-0">1,243</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="d-flex align-items-center">
                    <span class="text-success me-2"><i class="fas fa-arrow-up"></i> 12%</span>
                    <small class="text-muted">Since last month</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-calendar-check text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Active Events</h6>
                        <h3 class="mb-0">48</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="d-flex align-items-center">
                    <span class="text-success me-2"><i class="fas fa-arrow-up"></i> 8%</span>
                    <small class="text-muted">Since last month</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-bookmark text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Reservations</h6>
                        <h3 class="mb-0">156</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="d-flex align-items-center">
                    <span class="text-success me-2"><i class="fas fa-arrow-up"></i> 24%</span>
                    <small class="text-muted">Since last month</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-dollar-sign text-info fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Revenue</h6>
                        <h3 class="mb-0">$32,450</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="d-flex align-items-center">
                    <span class="text-success me-2"><i class="fas fa-arrow-up"></i> 18%</span>
                    <small class="text-muted">Since last month</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users & Traffic Overview -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">User Growth</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Day</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary active">Week</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Month</button>
                </div>
            </div>
            <div class="card-body">
                <!-- Simple static chart representation -->
                <div class="user-chart">
                    <div class="d-flex align-items-end mt-4" style="height: 250px;">
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 120px;"></div>
                            <small class="mt-2">Jan</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 100px;"></div>
                            <small class="mt-2">Feb</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 150px;"></div>
                            <small class="mt-2">Mar</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 180px;"></div>
                            <small class="mt-2">Apr</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 160px;"></div>
                            <small class="mt-2">May</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary bg-opacity-75 rounded-top w-75" style="height: 190px;"></div>
                            <small class="mt-2">Jun</small>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <div class="bg-primary rounded-top w-75" style="height: 220px;"></div>
                            <small class="mt-2">Jul</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">User Distribution</h5>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
            <div class="card-body">
                <!-- User Types Distribution -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Travelers</span>
                        <span class="text-primary">842</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 68%;" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Local Guides</span>
                        <span class="text-success">254</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Administrators</span>
                        <span class="text-danger">12</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Inactive Users</span>
                        <span class="text-warning">135</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 7%;" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <!-- Location Distribution -->
                <h6 class="mt-4 mb-3">Top Locations</h6>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>France</span>
                        <span>32%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Italy</span>
                        <span>28%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Japan</span>
                        <span>15%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <!-- Latest Users -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Latest Users</h5>
                <a href="#" class="text-decoration-none small">View all</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="40" height="40" alt="User">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Traveler • Joined 2 days ago</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="40" height="40" alt="User">
                            <div>
                                <h6 class="mb-0">John Davis</h6>
                                <small class="text-muted">Local Guide • Joined 3 days ago</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/48.jpg" class="rounded-circle me-3" width="40" height="40" alt="User">
                            <div>
                                <h6 class="mb-0">Emma Wilson</h6>
                                <small class="text-muted">Traveler • Joined 5 days ago</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/22.jpg" class="rounded-circle me-3" width="40" height="40" alt="User">
                            <div>
                                <h6 class="mb-0">Michael Brown</h6>
                                <small class="text-muted">Local Guide • Joined 1 week ago</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/67.jpg" class="rounded-circle me-3" width="40" height="40" alt="User">
                            <div>
                                <h6 class="mb-0">Olivia Parker</h6>
                                <small class="text-muted">Traveler • Joined 1 week ago</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Events -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recent Events</h5>
                <a href="#" class="text-decoration-none small">View all</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                            <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-3" width="60" height="60" alt="Event">
                            <div>
                                <h6 class="mb-1">Paris Art and Culture Tour</h6>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success me-2">Active</span>
                                    <small class="text-muted">Created 2 days ago by Marie Dubois</small>
                                </div>
                                <small><i class="fas fa-users me-1 text-muted"></i> 5 participants</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                            <img src="https://images.unsplash.com/photo-1480796927426-f609979314bd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-3" width="60" height="60" alt="Event">
                            <div>
                                <h6 class="mb-1">Tokyo Food Adventure</h6>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success me-2">Active</span>
                                    <small class="text-muted">Created 3 days ago by Hiro Tanaka</small>
                                </div>
                                <small><i class="fas fa-users me-1 text-muted"></i> 8 participants</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                            <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-3" width="60" height="60" alt="Event">
                            <div>
                                <h6 class="mb-1">Rome Historical Walk</h6>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success me-2">Active</span>
                                    <small class="text-muted">Created 5 days ago by Marco Rossi</small>
                                </div>
                                <small><i class="fas fa-users me-1 text-muted"></i> 12 participants</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                            <img src="https://images.unsplash.com/photo-1535139262971-c51845709a48?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800" class="rounded me-3" width="60" height="60" alt="Event">
                            <div>
                                <h6 class="mb-1">Bali Temple and Rice Fields</h6>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-warning text-dark me-2">Pending</span>
                                    <small class="text-muted">Created 1 week ago by Putu Wijaya</small>
                                </div>
                                <small><i class="fas fa-users me-1 text-muted"></i> 3 participants</small>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection