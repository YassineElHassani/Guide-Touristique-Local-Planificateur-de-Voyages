@extends('client.dashboard')

@section('title', 'Create Itinerary')
@section('dashboard-title', 'Create New Itinerary')
@section('dashboard-breadcrumb', 'Create Itinerary')

@push('styles')
<style>
    .destination-card {
        cursor: pointer;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .destination-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .destination-card.selected {
        border: 2px solid var(--primary-color);
    }
    
    .destination-img {
        height: 120px;
        object-fit: cover;
    }
    
    .days-input {
        width: 60px;
    }
    
    .order-input {
        width: 60px;
    }
    
    .selected-destinations {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .step-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }
    
    .step-item:not(:first-child):before {
        content: "";
        position: absolute;
        width: 100%;
        height: 3px;
        background-color: var(--light-gray);
        top: 15px;
        left: -50%;
        z-index: 1;
    }
    
    .step-item.active:before {
        background-color: var(--primary-color);
    }
    
    .step-item.completed:before {
        background-color: var(--success-color);
    }
    
    .step-counter {
        position: relative;
        z-index: 2;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: var(--light-gray);
        color: var(--dark-color);
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .step-item.active .step-counter {
        background-color: var(--primary-color);
        color: white;
    }
    
    .step-item.completed .step-counter {
        background-color: var(--success-color);
        color: white;
    }
    
    .step-name {
        font-weight: 500;
        color: var(--gray-color);
    }
    
    .step-item.active .step-name,
    .step-item.completed .step-name {
        color: var(--dark-color);
        font-weight: 600;
    }
</style>
@endpush

@section('dashboard-content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Step Indicator -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="steps d-flex w-100">
                <div class="step-item active">
                    <div class="step-counter">1</div>
                    <div class="step-name">Basic Info</div>
                </div>
                <div class="step-item">
                    <div class="step-counter">2</div>
                    <div class="step-name">Add Destinations</div>
                </div>
                <div class="step-item">
                    <div class="step-counter">3</div>
                    <div class="step-name">Organize Timeline</div>
                </div>
                <div class="step-item">
                    <div class="step-counter">4</div>
                    <div class="step-name">Review & Save</div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('client.itineraries.store') }}" method="POST" id="createItineraryForm">
    @csrf
    
    <!-- Step 1: Basic Info -->
    <div class="card border-0 shadow-sm mb-4" id="step1">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Basic Information</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="name" class="form-label">Itinerary Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g. Summer European Tour">
                </div>
                
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="col-md-12">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Add notes or description for this itinerary">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            <button type="button" class="btn btn-primary" id="nextToStep2">Next: Add Destinations</button>
        </div>
    </div>
    
    <!-- Step 2: Add Destinations -->
    <div class="card border-0 shadow-sm mb-4" id="step2" style="display: none;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Add Destinations</h5>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchDestination" placeholder="Search destinations...">
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterCategory">
                        <option value="">All Categories</option>
                        @foreach($destinations->pluck('category')->unique() as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row g-3 mb-4" id="destinationsContainer">
                @foreach($destinations as $index => $destination)
                    <div class="col-md-4" data-category="{{ $destination->category }}">
                        <div class="card destination-card" data-destination-id="{{ $destination->id }}">
                            <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" class="card-img-top destination-img" alt="{{ $destination->name }}">
                            <div class="card-body">
                                <h6 class="card-title">{{ $destination->name }}</h6>
                                <p class="card-text small text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $destination->category }}
                                </p>
                                <p class="card-text small">{{ Str::limit($destination->description, 60) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h5 class="mb-3">Selected Destinations</h5>
            <div class="selected-destinations">
                <table class="table" id="selectedDestinationsTable">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="no-destinations-row">
                            <td colspan="3" class="text-center py-3">No destinations selected. Click on destinations above to add them.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between py-3">
            <button type="button" class="btn btn-outline-secondary" id="backToStep1">Back</button>
            <button type="button" class="btn btn-primary" id="nextToStep3">Next: Organize Timeline</button>
        </div>
    </div>
    
    <!-- Step 3: Organize Timeline -->
    <div class="card border-0 shadow-sm mb-4" id="step3" style="display: none;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Organize Timeline</h5>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Assign each destination to a specific day of your trip and set the order for that day.
            </div>
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="timelineTable">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Category</th>
                                    <th style="width: 120px;">Day</th>
                                    <th style="width: 120px;">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- This will be populated with selected destinations -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <h6>Trip Duration:</h6>
                    <p>
                        <span id="tripDuration">0</span> days 
                        (<span id="startDateDisplay">--/--/----</span> to 
                        <span id="endDateDisplay">--/--/----</span>)
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between py-3">
            <button type="button" class="btn btn-outline-secondary" id="backToStep2">Back</button>
            <button type="button" class="btn btn-primary" id="nextToStep4">Next: Review & Save</button>
        </div>
    </div>
    
    <!-- Step 4: Review & Save -->
    <div class="card border-0 shadow-sm mb-4" id="step4" style="display: none;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Review & Save</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <span id="reviewName"></span></p>
                            <p><strong>Dates:</strong> <span id="reviewDates"></span></p>
                            <p><strong>Duration:</strong> <span id="reviewDuration"></span> days</p>
                            <p><strong>Description:</strong> <span id="reviewDescription">-</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Destinations</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Destinations:</strong> <span id="reviewTotalDestinations">0</span></p>
                            <div id="reviewDestinationsByDay">
                                <!-- This will be populated with destinations by day -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-warning mt-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Please review all information carefully before submitting. You can go back to previous steps to make changes.
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between py-3">
            <button type="button" class="btn btn-outline-secondary" id="backToStep3">Back</button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Create Itinerary
            </button>
        </div>
    </div>
    
    <!-- Hidden inputs for selected destinations -->
    <div id="selectedDestinationsInputs"></div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables to store form data
        let selectedDestinations = [];
        
        // Step navigation
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const step4 = document.getElementById('step4');
        
        // Step 1 -> 2
        document.getElementById('nextToStep2').addEventListener('click', function() {
            if (validateStep1()) {
                step1.style.display = 'none';
                step2.style.display = 'block';
                updateStepIndicator(2);
                
                // Update trip duration in step 3
                const startDate = new Date(document.getElementById('start_date').value);
                const endDate = new Date(document.getElementById('end_date').value);
                const timeDiff = endDate.getTime() - startDate.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                
                document.getElementById('tripDuration').textContent = dayDiff;
                document.getElementById('startDateDisplay').textContent = formatDate(startDate);
                document.getElementById('endDateDisplay').textContent = formatDate(endDate);
            }
        });
        
        // Step 2 -> 1
        document.getElementById('backToStep1').addEventListener('click', function() {
            step2.style.display = 'none';
            step1.style.display = 'block';
            updateStepIndicator(1);
        });
        
        // Step 2 -> 3
        document.getElementById('nextToStep3').addEventListener('click', function() {
            if (validateStep2()) {
                step2.style.display = 'none';
                step3.style.display = 'block';
                updateStepIndicator(3);
                populateTimelineTable();
            }
        });
        
        // Step 3 -> 2
        document.getElementById('backToStep2').addEventListener('click', function() {
            step3.style.display = 'none';
            step2.style.display = 'block';
            updateStepIndicator(2);
        });
        
        // Step 3 -> 4
        document.getElementById('nextToStep4').addEventListener('click', function() {
            if (validateStep3()) {
                step3.style.display = 'none';
                step4.style.display = 'block';
                updateStepIndicator(4);
                populateReviewStep();
            }
        });
        
        // Step 4 -> 3
        document.getElementById('backToStep3').addEventListener('click', function() {
            step4.style.display = 'none';
            step3.style.display = 'block';
            updateStepIndicator(3);
        });
        
        // Select destination
        const destinationCards = document.querySelectorAll('.destination-card');
        destinationCards.forEach(card => {
            card.addEventListener('click', function() {
                const destinationId = this.getAttribute('data-destination-id');
                
                // Check if already selected
                const isSelected = selectedDestinations.some(d => d.id === destinationId);
                
                if (isSelected) {
                    // Remove from selected
                    selectedDestinations = selectedDestinations.filter(d => d.id !== destinationId);
                    this.classList.remove('selected');
                } else {
                    // Add to selected
                    const name = this.querySelector('.card-title').textContent;
                    const category = this.querySelector('.card-text.small.text-muted').textContent.trim().replace('location_on', '').trim();
                    selectedDestinations.push({
                        id: destinationId,
                        name: name,
                        category: category
                    });
                    this.classList.add('selected');
                }
                
                updateSelectedDestinationsTable();
            });
        });
        
        // Filter destinations by category
        document.getElementById('filterCategory').addEventListener('change', function() {
            const category = this.value;
            const destinations = document.querySelectorAll('#destinationsContainer > div');
            
            destinations.forEach(destination => {
                if (!category || destination.getAttribute('data-category') === category) {
                    destination.style.display = 'block';
                } else {
                    destination.style.display = 'none';
                }
            });
        });
        
        // Search destinations
        document.getElementById('searchDestination').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const destinations = document.querySelectorAll('.destination-card');
            
            destinations.forEach(destination => {
                const name = destination.querySelector('.card-title').textContent.toLowerCase();
                const parent = destination.closest('.col-md-4');
                
                if (name.includes(searchTerm)) {
                    parent.style.display = 'block';
                } else {
                    parent.style.display = 'none';
                }
            });
        });
        
        // Helper Functions
        function validateStep1() {
            const name = document.getElementById('name').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (!name || !startDate || !endDate) {
                alert('Please fill in all required fields.');
                return false;
            }
            
            if (new Date(endDate) < new Date(startDate)) {
                alert('End date cannot be before start date.');
                return false;
            }
            
            return true;
        }
        
        function validateStep2() {
            if (selectedDestinations.length === 0) {
                alert('Please select at least one destination.');
                return false;
            }
            
            return true;
        }
        
        function validateStep3() {
            const dayInputs = document.querySelectorAll('input[name="days[]"]');
            const orderInputs = document.querySelectorAll('input[name="orders[]"]');
            
            let valid = true;
            
            dayInputs.forEach((input, index) => {
                if (!input.value || isNaN(parseInt(input.value)) || parseInt(input.value) < 1) {
                    valid = false;
                }
            });
            
            orderInputs.forEach((input, index) => {
                if (!input.value || isNaN(parseInt(input.value)) || parseInt(input.value) < 1) {
                    valid = false;
                }
            });
            
            if (!valid) {
                alert('Please assign a valid day and order for each destination.');
                return false;
            }
            
            return true;
        }
        
        function updateStepIndicator(step) {
            const steps = document.querySelectorAll('.step-item');
            
            steps.forEach((item, index) => {
                if (index + 1 < step) {
                    item.classList.add('completed');
                    item.classList.remove('active');
                } else if (index + 1 === step) {
                    item.classList.add('active');
                    item.classList.remove('completed');
                } else {
                    item.classList.remove('active');
                    item.classList.remove('completed');
                }
            });
        }
        
        function updateSelectedDestinationsTable() {
            const table = document.getElementById('selectedDestinationsTable');
            const tbody = table.querySelector('tbody');
            const noDestinationsRow = document.querySelector('.no-destinations-row');
            
            // Clear existing rows
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
            
            if (selectedDestinations.length === 0) {
                tbody.appendChild(noDestinationsRow);
            } else {
                selectedDestinations.forEach(destination => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>${destination.name}</td>
                        <td>${destination.category}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-destination" data-id="${destination.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    `;
                    
                    tbody.appendChild(row);
                });
                
                // Add event listeners to remove buttons
                const removeButtons = document.querySelectorAll('.remove-destination');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const destinationId = this.getAttribute('data-id');
                        
                        // Remove from selectedDestinations
                        selectedDestinations = selectedDestinations.filter(d => d.id !== destinationId);
                        
                        // Remove selected class from card
                        const card = document.querySelector(`.destination-card[data-destination-id="${destinationId}"]`);
                        if (card) {
                            card.classList.remove('selected');
                        }
                        
                        updateSelectedDestinationsTable();
                    });
                });
            }
        }
        
        function populateTimelineTable() {
            const table = document.getElementById('timelineTable');
            const tbody = table.querySelector('tbody');
            
            // Clear existing rows
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
            
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            const tripDuration = Math.ceil((endDate - startDate) / (1000 * 3600 * 24)) + 1;
            
            selectedDestinations.forEach((destination, index) => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${destination.name}
                        <input type="hidden" name="destination_ids[]" value="${destination.id}">
                    </td>
                    <td>${destination.category}</td>
                    <td>
                        <select class="form-select days-input" name="days[]" required>
                            ${generateDayOptions(tripDuration)}
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control order-input" name="orders[]" min="1" value="1" required>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }
        
        function generateDayOptions(days) {
            let options = '';
            for (let i = 1; i <= days; i++) {
                options += `<option value="${i}">Day ${i}</option>`;
            }
            return options;
        }
        
        function populateReviewStep() {
            // Basic info
            document.getElementById('reviewName').textContent = document.getElementById('name').value;
            
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            document.getElementById('reviewDates').textContent = `${formatDate(startDate)} to ${formatDate(endDate)}`;
            
            const tripDuration = Math.ceil((endDate - startDate) / (1000 * 3600 * 24)) + 1;
            document.getElementById('reviewDuration').textContent = tripDuration;
            
            const description = document.getElementById('description').value;
            document.getElementById('reviewDescription').textContent = description || '-';
            
            // Destinations
            document.getElementById('reviewTotalDestinations').textContent = selectedDestinations.length;
            
            const destinationsByDay = {};
            const dayInputs = document.querySelectorAll('select[name="days[]"]');
            
            dayInputs.forEach((input, index) => {
                const day = input.value;
                const destinationName = selectedDestinations[index].name;
                
                if (!destinationsByDay[day]) {
                    destinationsByDay[day] = [];
                }
                
                destinationsByDay[day].push(destinationName);
            });
            
            // Populate destinations by day
            const reviewDestinationsByDay = document.getElementById('reviewDestinationsByDay');
            reviewDestinationsByDay.innerHTML = '';
            
            for (let day = 1; day <= tripDuration; day++) {
                const destinations = destinationsByDay[day] || [];
                
                const dayElement = document.createElement('div');
                dayElement.classList.add('mb-3');
                
                let destinationsList = '';
                if (destinations.length > 0) {
                    destinationsList = destinations.map(d => `<li>${d}</li>`).join('');
                } else {
                    destinationsList = '<li class="text-muted">No destinations planned</li>';
                }
                
                dayElement.innerHTML = `
                    <h6 class="mb-2">Day ${day} - ${formatDate(new Date(startDate).setDate(startDate.getDate() + day - 1))}</h6>
                    <ul class="mb-0">
                        ${destinationsList}
                    </ul>
                `;
                
                reviewDestinationsByDay.appendChild(dayElement);
            }
            
            // Create hidden inputs for form submission
            createHiddenInputs();
        }
        
        function createHiddenInputs() {
            const container = document.getElementById('selectedDestinationsInputs');
            container.innerHTML = '';
            
            // Already have destination_ids[], days[], and orders[] in the form
        }
        
        function formatDate(date) {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }
    });
</script>
@endpush