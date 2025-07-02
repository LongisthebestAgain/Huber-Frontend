@extends('layouts.app')
@section('title', 'Register Huber - Registration Page')
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

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    @if ($errors->has('registration'))
                        {{ $errors->first('registration') }}
                    @else
                        Please check the form for errors.
                    @endif
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                
                <!-- Role Selection -->
                <h4 class="text-center mb-4">Choose Your Role</h4>
                <div class="role-selector">
                    <div class="role-option {{ old('user_role', 'passenger') == 'passenger' ? 'active' : '' }}" 
                         onclick="selectRole('passenger')" data-role="passenger">
                        <i class="fas fa-user"></i>
                        <h5>Passenger</h5>
                        <p class="text-muted">Book rides and travel</p>
                    </div>
                    <div class="role-option {{ old('user_role') == 'driver' ? 'active' : '' }}" 
                         onclick="selectRole('driver')" data-role="driver">
                        <i class="fas fa-car"></i>
                        <h5>Driver</h5>
                        <p class="text-muted">Offer rides and earn</p>
                    </div>
                </div>

                <input type="hidden" name="user_role" id="user_role" value="{{ old('user_role', 'passenger') }}">

                <!-- Personal Information -->
                <h4 class="mb-4">Personal Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                               value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                               value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                       value="{{ old('phone_number') }}" required>
                @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>

                <!-- Driver-specific fields -->
                <div class="driver-specific {{ old('user_role') == 'driver' ? 'show' : '' }}" id="driverFields">
                    <h5><i class="fas fa-car"></i> Driver Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">License Number</label>
                            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" 
                                   value="{{ old('license_number') }}">
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vehicle Information</label>
                            <input type="text" name="vehicle_info" class="form-control @error('vehicle_info') is-invalid @enderror" 
                                   placeholder="e.g., Toyota Camry 2020" value="{{ old('vehicle_info') }}">
                            @error('vehicle_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
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

                <button type="submit" class="btn btn-primary btn-register">
                    Create Account
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Role selection
        function selectRole(role) {
            // Update UI
            document.querySelectorAll('.role-option').forEach(option => {
                option.classList.remove('active');
            });
            document.querySelector(`[data-role="${role}"]`).classList.add('active');
            
            // Update hidden input
            document.getElementById('user_role').value = role;
            
            // Show/hide driver-specific fields
            const driverFields = document.getElementById('driverFields');
            
            if (role === 'driver') {
                driverFields.classList.add('show');
            } else {
                driverFields.classList.remove('show');
            }
        }

        console.log('🚗 Hubber Registration System Loaded');
    </script>
@endsection