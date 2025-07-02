@extends('layouts.app') @section('title', 'Login Huber')
@section('style')

    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg,
                    var(--primary-color),
                    var(--dark-color));
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 4rem 2rem 2rem 2rem; /* Increased top padding */
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .role-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .role-option {
            flex: 1;
            text-align: center;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
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
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
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
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
@endsection
@section('content')

    
        <a href="{{ route('home') }}" class="back-to-home">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <i class="fas fa-car-side"></i>
                    <h2>Welcome Back</h2>
                    <p class="text-muted">Sign in to continue to Hubber</p>
                </div>

                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        @if ($errors->has('login'))
                            {{ $errors->first('login') }}
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

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="role-selector">
                        <div class="role-option {{ old('user_role', 'passenger') == 'passenger' ? 'active' : '' }}" 
                             onclick="selectRole(this, 'passenger')" data-role="passenger">
                            <i class="fas fa-user"></i>
                            <div>Passenger</div>
                        </div>
                        <div class="role-option {{ old('user_role') == 'driver' ? 'active' : '' }}" 
                             onclick="selectRole(this, 'driver')" data-role="driver">
                            <i class="fas fa-car"></i>
                            <div>Driver</div>
                        </div>
                    </div>

                    <input type="hidden" name="user_role" id="user_role" value="{{ old('user_role', 'passenger') }}">

                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Email address" value="{{ old('email') }}" required />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Password" required />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" />
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-primary" onclick="showForgotPassword()">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        Sign In
                    </button>
                </form>

                <div class="register-link">
                    <p class="mb-0">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary">Register</a>
                    </p>
                </div>

                <!-- Session Info -->
                @if (Session::has('user'))
                    <div class="mt-3 text-center" style="font-size: 0.8rem; color: #666">
                        <span>Logged in as: {{ Session::get('user')['first_name'] }} {{ Session::get('user')['last_name'] }} ({{ Session::get('user_role') }})</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Role selection
            function selectRole(element, role) {
                // Remove active class from all options
                document.querySelectorAll(".role-option").forEach((option) => {
                    option.classList.remove("active");
                });
                // Add active class to selected option
                element.classList.add("active");
                
                // Update hidden input
                document.getElementById('user_role').value = role;
            }

            // Forgot password (placeholder)
            function showForgotPassword() {
                alert("Password reset functionality would be implemented here.\n\nFor testing, use the provided test credentials.");
            }
        </script>

@endsection
