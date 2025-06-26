@extends('layouts.app') @section('Login Huber', 'login Page')
@section('style')

    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg,
                    var(--primary-color),
                    var(--dark-color));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
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

        .test-credentials {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .credential-item {
            margin-bottom: 0.5rem;
            padding: 0.25rem 0;
        }

        .credential-item:last-child {
            margin-bottom: 0;
        }

        .alert {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .quick-login-btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
            border-radius: 5px;
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
                <div id="loginAlert" class="alert alert-danger d-none" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="alertMessage">Invalid credentials!</span>
                </div>
                <div id="successAlert" class="alert alert-success d-none" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span id="successMessage">Login successful!</span>
                </div>

                <form id="loginForm">
                    <div class="role-selector">
                        <div class="role-option active" onclick="selectRole(this, 'passenger')" data-role="passenger">
                            <i class="fas fa-user"></i>
                            <div>Passenger</div>
                        </div>
                        <div class="role-option" onclick="selectRole(this, 'driver')" data-role="driver">
                            <i class="fas fa-car"></i>
                            <div>Driver</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" class="form-control" placeholder="Email address" required />
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" class="form-control" placeholder="Password" required />
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" />
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-primary" onclick="showForgotPassword()">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login">
                        <span id="loginButtonText">Sign In</span>
                        <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </form>

                <div class="register-link">
                    <p class="mb-0">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary">Register</a>
                    </p>
                </div>

                <!-- Session Info -->
                <div id="sessionInfo" class="mt-3 text-center" style="font-size: 0.8rem; color: #666">
                    <span id="sessionStatus">No active session</span>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Authentication System with localStorage
            class AuthSystem {
                constructor() {
                    this.currentRole = "passenger";
                    this.initializeTestUsers();
                    this.checkExistingSession();
                }

                // Initialize test users in localStorage
                initializeTestUsers() {
                    const testUsers = {
                        "passenger@test.com": {
                            password: "password123",
                            role: "passenger",
                            name: "John Doe",
                            id: "user_001",
                            profile: {
                                phone: "+1234567890",
                                location: "New York, NY",
                                joined: "2024-01-15",
                            },
                        },
                        "driver@test.com": {
                            password: "password123",
                            role: "driver",
                            name: "Michael Smith",
                            id: "driver_001",
                            profile: {
                                phone: "+1234567891",
                                license: "DL123456789",
                                vehicle: "Toyota Camry 2020",
                                rating: 4.8,
                                totalRides: 156,
                            },
                        },
                        "admin@test.com": {
                            password: "admin123",
                            role: "admin",
                            name: "Sarah Johnson",
                            id: "admin_001",
                            profile: {
                                phone: "+1234567892",
                                department: "Platform Operations",
                                level: "Senior Administrator",
                            },
                        },
                    };

                    // Store test users if not already stored
                    if (!localStorage.getItem("hubber_users")) {
                        localStorage.setItem(
                            "hubber_users",
                            JSON.stringify(testUsers),
                        );
                    }
                }

                // Check for existing session
                checkExistingSession() {
                    const session = localStorage.getItem("hubber_session");
                    if (session) {
                        const sessionData = JSON.parse(session);
                        const sessionExpiry = new Date(sessionData.expiry);

                        if (sessionExpiry > new Date()) {
                            this.updateSessionInfo(
                                `Active session: ${sessionData.user.name} (${sessionData.user.role})`,
                            );
                            // Auto-redirect if valid session exists
                            setTimeout(() => {
                                this.redirectToDashboard(sessionData.user.role);
                            }, 2000);
                        } else {
                            this.clearSession();
                        }
                    }
                }

                // Login function
                login(email, password, selectedRole) {
                    const users = JSON.parse(
                        localStorage.getItem("hubber_users"),
                    );
                    const user = users[email];

                    if (!user) {
                        throw new Error("User not found");
                    }

                    if (user.password !== password) {
                        throw new Error("Invalid password");
                    }

                    if (user.role !== selectedRole) {
                        throw new Error(
                            `Invalid role. This account is registered as ${user.role}`,
                        );
                    }

                    // Create session
                    const sessionData = {
                        user: {
                            email: email,
                            name: user.name,
                            role: user.role,
                            id: user.id,
                            profile: user.profile,
                        },
                        loginTime: new Date().toISOString(),
                        expiry: new Date(
                            Date.now() + 24 * 60 * 60 * 1000,
                        ).toISOString(), // 24 hours
                        sessionId: this.generateSessionId(),
                    };

                    localStorage.setItem(
                        "hubber_session",
                        JSON.stringify(sessionData),
                    );

                    // Store login history
                    this.addToLoginHistory(sessionData);

                    return sessionData;
                }

                // Generate unique session ID
                generateSessionId() {
                    return (
                        "session_" +
                        Date.now() +
                        "_" +
                        Math.random().toString(36).substr(2, 9)
                    );
                }

                // Add to login history
                addToLoginHistory(sessionData) {
                    let history = JSON.parse(
                        localStorage.getItem("hubber_login_history") || "[]",
                    );
                    history.unshift({
                        email: sessionData.user.email,
                        role: sessionData.user.role,
                        loginTime: sessionData.loginTime,
                        sessionId: sessionData.sessionId,
                    });

                    // Keep only last 10 logins
                    history = history.slice(0, 10);
                    localStorage.setItem(
                        "hubber_login_history",
                        JSON.stringify(history),
                    );
                }

                // Clear session
                clearSession() {
                    localStorage.removeItem("hubber_session");
                    this.updateSessionInfo("No active session");
                }

                // Update session info display
                updateSessionInfo(message) {
                    document.getElementById("sessionStatus").textContent =
                        message;
                }

                // Redirect to appropriate dashboard
                redirectToDashboard(role) {
                    const dashboards = {
                        passenger: "passenger-dashboard.html",
                        driver: "driver-dashboard.html",
                        admin: "admin-dashboard.html",
                    };

                    window.location.href = dashboards[role] || "index.html";
                }

                // Get current session
                getCurrentSession() {
                    const session = localStorage.getItem("hubber_session");
                    if (session) {
                        const sessionData = JSON.parse(session);
                        const sessionExpiry = new Date(sessionData.expiry);

                        if (sessionExpiry > new Date()) {
                            return sessionData;
                        } else {
                            this.clearSession();
                        }
                    }
                    return null;
                }
            }

            // Initialize auth system
            const auth = new AuthSystem();

            // Role selection
            let selectedRole = "passenger";

            function selectRole(element, role) {
                // Remove active class from all options
                document.querySelectorAll(".role-option").forEach((option) => {
                    option.classList.remove("active");
                });
                // Add active class to selected option
                element.classList.add("active");
                selectedRole = role;
            }

            // Quick login function
            function quickLogin(email, password, role) {
                document.getElementById("email").value = email;
                document.getElementById("password").value = password;

                // Select the correct role
                document.querySelectorAll(".role-option").forEach((option) => {
                    option.classList.remove("active");
                    if (option.dataset.role === role) {
                        option.classList.add("active");
                        selectedRole = role;
                    }
                });

                // Submit the form
                handleLogin();
            }

            // Handle login
            function handleLogin() {
                const email = document.getElementById("email").value;
                const password = document.getElementById("password").value;
                const rememberMe = document.getElementById("remember").checked;

                // Show loading state
                showLoginLoading(true);
                hideAlerts();

                // Simulate network delay
                setTimeout(() => {
                    try {
                        const sessionData = auth.login(
                            email,
                            password,
                            selectedRole,
                        );

                        showSuccess(`Welcome back, ${sessionData.user.name}!`);

                        // Update session info
                        auth.updateSessionInfo(
                            `Logged in as: ${sessionData.user.name} (${sessionData.user.role})`,
                        );

                        // Redirect after success message
                        setTimeout(() => {
                            auth.redirectToDashboard(sessionData.user.role);
                        }, 1500);
                    } catch (error) {
                        showError(error.message);
                    } finally {
                        showLoginLoading(false);
                    }
                }, 1000);
            }

            // Form submission
            document
                .getElementById("loginForm")
                .addEventListener("submit", function(e) {
                    e.preventDefault();
                    handleLogin();
                });

            // Show/hide loading state
            function showLoginLoading(loading) {
                const button = document.querySelector(".btn-login");
                const buttonText = document.getElementById("loginButtonText");
                const spinner = document.getElementById("loginSpinner");

                if (loading) {
                    button.disabled = true;
                    buttonText.textContent = "Signing In...";
                    spinner.classList.remove("d-none");
                } else {
                    button.disabled = false;
                    buttonText.textContent = "Sign In";
                    spinner.classList.add("d-none");
                }
            }

            // Show error message
            function showError(message) {
                hideAlerts();
                document.getElementById("alertMessage").textContent = message;
                document
                    .getElementById("loginAlert")
                    .classList.remove("d-none");
            }

            // Show success message
            function showSuccess(message) {
                hideAlerts();
                document.getElementById("successMessage").textContent = message;
                document
                    .getElementById("successAlert")
                    .classList.remove("d-none");
            }

            // Hide all alerts
            function hideAlerts() {
                document.getElementById("loginAlert").classList.add("d-none");
                document.getElementById("successAlert").classList.add("d-none");
            }

            // Forgot password (placeholder)
            function showForgotPassword() {
                alert(
                    "Password reset functionality would be implemented here.\n\nFor testing, use the provided test credentials.",
                );
            }

            // Debug functions for testing
            window.debugAuth = {
                clearAllData: function() {
                    localStorage.clear();
                    location.reload();
                },
                showSession: function() {
                    console.log("Current Session:", auth.getCurrentSession());
                },
                showUsers: function() {
                    console.log(
                        "Stored Users:",
                        JSON.parse(localStorage.getItem("hubber_users")),
                    );
                },
                showLoginHistory: function() {
                    console.log(
                        "Login History:",
                        JSON.parse(
                            localStorage.getItem("hubber_login_history") ||
                            "[]",
                        ),
                    );
                },
            };
        </script>

@endsection
