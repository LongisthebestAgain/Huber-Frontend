@extends('layouts.app')
@section('title', 'Register Huber - Register Page')
@section('style')
    <style>
        .register-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 4rem 2rem 2rem 2rem; /* Increase top padding */
        }

        .register-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .btn-register {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .role-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .role-option {
            flex: 1;
            text-align: center;
            padding: 1.5rem;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-option:hover {
            border-color: var(--primary-color);
        }

        .role-option.active {
            border-color: var(--primary-color);
            background-color: rgba(76, 132, 255, 0.1);
        }

        .role-option i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .driver-specific {
            display: none;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .driver-specific.show {
            display: block;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
            background-color: rgba(76, 132, 255, 0.05);
        }

        .file-upload.has-file {
            border-color: var(--success-color);
            background-color: rgba(46, 204, 113, 0.1);
        }

        .back-to-home {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-to-home:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .progress-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .progress-step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.5rem;
            color: #6c757d;
            font-weight: 600;
        }

        .progress-step.active {
            background: var(--primary-color);
            color: white;
        }

        .progress-step.completed {
            background: var(--success-color);
            color: white;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .terms-checkbox {
            margin: 1rem 0;
        }
    </style>
@endsection

@section('content')
    <a href="{{ route('home') }}" class="back-to-home">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
    
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <i class="fas fa-user-plus"></i>
                <h2>Join Hubber</h2>
                <p class="text-muted">Create your account and start your journey</p>
            </div>

            <!-- Progress Indicator -->
            <div class="progress-indicator">
                <div class="progress-step active" id="step1">1</div>
                <div class="progress-step" id="step2">2</div>
                <div class="progress-step" id="step3">3</div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Step 1: Role Selection -->
            <div id="stepRoleSelection" class="registration-step">
                <h4 class="text-center mb-4">Choose Your Role</h4>
                <div class="role-selector">
                    <div class="role-option" onclick="selectRole('passenger')" data-role="passenger">
                        <i class="fas fa-user"></i>
                        <h5>Passenger</h5>
                        <p class="text-muted">Book rides and travel</p>
                    </div>
                    <div class="role-option" onclick="selectRole('driver')" data-role="driver">
                        <i class="fas fa-car"></i>
                        <h5>Driver</h5>
                        <p class="text-muted">Offer rides and earn</p>
                    </div>
                </div>
                <button class="btn btn-primary btn-register" onclick="nextStep()" disabled id="roleNextBtn">
                    Continue
                </button>
            </div>

            <!-- Step 2: Personal Information -->
            <div id="stepPersonalInfo" class="registration-step d-none">
                <h4 class="text-center mb-4">Personal Information</h4>
                <form id="personalInfoForm">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                    </div>
                    
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" required>
                    
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" required>
                    
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                    
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" required>

                    <!-- Driver-specific fields -->
                    <div class="driver-specific" id="driverFields">
                        <h5><i class="fas fa-car"></i> Driver Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">License Number</label>
                                <input type="text" class="form-control" id="licenseNumber">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">License Expiry</label>
                                <input type="date" class="form-control" id="licenseExpiry">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Make</label>
                                <input type="text" class="form-control" id="vehicleMake" placeholder="e.g., Toyota">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Model</label>
                                <input type="text" class="form-control" id="vehicleModel" placeholder="e.g., Camry">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Year</label>
                                <input type="number" class="form-control" id="vehicleYear" min="2000" max="2024">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Color</label>
                                <input type="text" class="form-control" id="vehicleColor">
                            </div>
                        </div>

                        <label class="form-label">License Plate</label>
                        <input type="text" class="form-control" id="licensePlate">
                    </div>
                </form>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="previousStep()">Back</button>
                    <button class="btn btn-primary flex-fill" onclick="nextStep()">Continue</button>
                </div>
            </div>

            <!-- Step 3: Document Upload (Driver only) or Completion -->
            <div id="stepDocuments" class="registration-step d-none">
                <div id="driverDocuments" class="d-none">
                    <h4 class="text-center mb-4">Upload Documents</h4>
                    <p class="text-muted text-center">Please upload the required documents for driver verification</p>

                    <div class="mb-3">
                        <label class="form-label">Driver's License</label>
                        <div class="file-upload" onclick="document.getElementById('licenseFile').click()">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
                            <p class="mb-0">Click to upload driver's license</p>
                            <small class="text-muted">JPG, PNG, PDF (max 5MB)</small>
                        </div>
                        <input type="file" id="licenseFile" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" onchange="handleFileUpload(this, 'license')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Registration</label>
                        <div class="file-upload" onclick="document.getElementById('registrationFile').click()">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
                            <p class="mb-0">Click to upload vehicle registration</p>
                            <small class="text-muted">JPG, PNG, PDF (max 5MB)</small>
                        </div>
                        <input type="file" id="registrationFile" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" onchange="handleFileUpload(this, 'registration')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Insurance Certificate</label>
                        <div class="file-upload" onclick="document.getElementById('insuranceFile').click()">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
                            <p class="mb-0">Click to upload insurance certificate</p>
                            <small class="text-muted">JPG, PNG, PDF (max 5MB)</small>
                        </div>
                        <input type="file" id="insuranceFile" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" onchange="handleFileUpload(this, 'insurance')">
                    </div>
                </div>

                <div id="passengerCompletion" class="text-center">
                    <h4 class="mb-4">Almost Done!</h4>
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p class="text-muted">Review your information and complete registration</p>
                </div>

                <!-- Terms and Conditions -->
                <div class="terms-checkbox">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="previousStep()">Back</button>
                    <button class="btn btn-primary flex-fill" onclick="completeRegistration()">
                        <span id="submitText">Create Account</span>
                        <span id="submitSpinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="mb-0">Already have an account? <a href="login" class="text-primary">Sign In</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedRole = '';
        let currentStep = 1;
        let uploadedFiles = {};

        // Role selection
        function selectRole(role) {
            selectedRole = role;
            
            // Update UI
            document.querySelectorAll('.role-option').forEach(option => {
                option.classList.remove('active');
            });
            document.querySelector(`[data-role="${role}"]`).classList.add('active');
            
            // Enable next button
            document.getElementById('roleNextBtn').disabled = false;
            
            // Show/hide driver-specific fields
            const driverFields = document.getElementById('driverFields');
            const driverDocuments = document.getElementById('driverDocuments');
            const passengerCompletion = document.getElementById('passengerCompletion');
            
            if (role === 'driver') {
                driverFields.classList.add('show');
                driverDocuments.classList.remove('d-none');
                passengerCompletion.classList.add('d-none');
            } else {
                driverFields.classList.remove('show');
                driverDocuments.classList.add('d-none');
                passengerCompletion.classList.remove('d-none');
            }
        }

        // Navigation functions
        function nextStep() {
            if (currentStep === 1) {
                if (!selectedRole) {
                    showAlert('Please select a role to continue', 'warning');
                    return;
                }
            } else if (currentStep === 2) {
                if (!validatePersonalInfo()) {
                    return;
                }
            }

            currentStep++;
            updateStepDisplay();
        }

        function previousStep() {
            currentStep--;
            updateStepDisplay();
        }

        function updateStepDisplay() {
            // Hide all steps
            document.querySelectorAll('.registration-step').forEach(step => {
                step.classList.add('d-none');
            });

            // Show current step
            const steps = ['stepRoleSelection', 'stepPersonalInfo', 'stepDocuments'];
            document.getElementById(steps[currentStep - 1]).classList.remove('d-none');

            // Update progress indicator
            document.querySelectorAll('.progress-step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                    step.innerHTML = '<i class="fas fa-check"></i>';
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                    step.textContent = index + 1;
                } else {
                    step.textContent = index + 1;
                }
            });
        }

        // Validation
        function validatePersonalInfo() {
            const required = ['firstName', 'lastName', 'email', 'phone', 'password', 'confirmPassword'];
            
            if (selectedRole === 'driver') {
                required.push('licenseNumber', 'vehicleMake', 'vehicleModel', 'vehicleYear', 'licensePlate');
            }

            for (let field of required) {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    showAlert(`Please fill in ${field.replace(/([A-Z])/g, ' $1').toLowerCase()}`, 'warning');
                    element.focus();
                    return false;
                }
            }

            // Check password match
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                showAlert('Passwords do not match', 'danger');
                return false;
            }

            // Check email format
            const email = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('Please enter a valid email address', 'warning');
                return false;
            }

            return true;
        }

        // File upload handling
        function handleFileUpload(input, type) {
            const file = input.files[0];
            if (!file) return;

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('File size must be less than 5MB', 'warning');
                input.value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                showAlert('Please upload JPG, PNG, or PDF files only', 'warning');
                input.value = '';
                return;
            }

            // Update UI
            const uploadDiv = input.parentElement.querySelector('.file-upload');
            uploadDiv.classList.add('has-file');
            uploadDiv.innerHTML = `
                <i class="fas fa-check-circle fa-2x text-success"></i>
                <p class="mb-0">${file.name}</p>
                <small class="text-success">File uploaded successfully</small>
            `;

            // Store file reference
            uploadedFiles[type] = file;
        }

        // Complete registration
        function completeRegistration() {
            if (!document.getElementById('agreeTerms').checked) {
                showAlert('Please agree to the Terms of Service and Privacy Policy', 'warning');
                return;
            }

            // For drivers, check if required documents are uploaded
            if (selectedRole === 'driver') {
                const requiredDocs = ['license', 'registration', 'insurance'];
                for (let doc of requiredDocs) {
                    if (!uploadedFiles[doc]) {
                        showAlert(`Please upload your ${doc} document`, 'warning');
                        return;
                    }
                }
            }

            // Show loading state
            document.getElementById('submitText').textContent = 'Creating Account...';
            document.getElementById('submitSpinner').classList.remove('d-none');

            // Simulate registration process
            setTimeout(() => {
                // Collect all form data
                const userData = {
                    role: selectedRole,
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    password: document.getElementById('password').value,
                    registrationDate: new Date().toISOString()
                };

                if (selectedRole === 'driver') {
                    userData.driverInfo = {
                        licenseNumber: document.getElementById('licenseNumber').value,
                        licenseExpiry: document.getElementById('licenseExpiry').value,
                        vehicle: {
                            make: document.getElementById('vehicleMake').value,
                            model: document.getElementById('vehicleModel').value,
                            year: document.getElementById('vehicleYear').value,
                            color: document.getElementById('vehicleColor').value,
                            plate: document.getElementById('licensePlate').value
                        },
                        documents: Object.keys(uploadedFiles),
                        verificationStatus: 'pending'
                    };
                }

                // Store user data
                const users = JSON.parse(localStorage.getItem('hubber_users') || '{}');
                users[userData.email] = {
                    password: userData.password,
                    role: userData.role,
                    name: `${userData.firstName} ${userData.lastName}`,
                    id: 'user_' + Date.now(),
                    profile: userData,
                    status: selectedRole === 'driver' ? 'pending' : 'active'
                };
                localStorage.setItem('hubber_users', JSON.stringify(users));

                // Show success message
                if (selectedRole === 'driver') {
                    showAlert('Registration submitted! Your account will be activated after document verification.', 'success');
                    setTimeout(() => {
                        // Remove any session before redirecting
                        localStorage.removeItem('hubber_session');
                        window.location.href = '/login';
                    }, 3000);
                } else {
                    showAlert('Registration successful! You can now log in.', 'success');
                    setTimeout(() => {
                        // Remove any session before redirecting
                        localStorage.removeItem('hubber_session');
                        window.location.href = '/login';
                    }, 2000);
                }

            }, 2000);
        }

        // Utility functions
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        console.log('🚗 Hubber Registration System Loaded');
    </script>
@endsection