@extends('layouts.app') @section('Driver Profile Huber', 'Driver Profile Page')
@section('style')
<style>
        body {
            font-family: 'Inter', sans-serif;
            background: white;
            min-height: 100vh;
        }

        .profile-container {
            padding-top: 100px;
            min-height: 100vh;
        }

        .profile-header {
            background: white;
            border-radius: 25px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        .profile-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            margin-bottom: 2rem;
            border: 6px solid var(--primary-color);
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .profile-badge {
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin: 2rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-card h3 i {
            color: var(--primary-color);
        }

        .review-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1.5rem 0;
        }

        .review-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .rating {
            color: #ffd700;
            margin-bottom: 0.5rem;
        }

        .vehicle-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: rgba(76, 132, 255, 0.05);
            border-radius: 15px;
            margin-bottom: 1rem;
        }

        .vehicle-image {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .back-button {
            position: absolute;
            top: 2rem;
            left: 2rem;
            background: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: var(--dark-color);
        }

        .back-button:hover {
            transform: translateX(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection

@section('content')

    <div class="profile-container">
        <div class="container">
            <a href="{{ route('home') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>

            <!-- Profile Header -->
            <div class="profile-header">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e" alt="Driver" class="profile-avatar">
                <h1 class="profile-name">Michael Smith</h1>
                <span class="profile-badge">Professional Driver</span>
                <p class="text-muted">Member since January 2024</p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">4.9</div>
                        <div class="stat-label">Rating</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">127</div>
                        <div class="stat-label">Rides</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">98%</div>
                        <div class="stat-label">Completion</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- About Section -->
                    <div class="info-card">
                        <h3><i class="fas fa-user"></i> About Michael</h3>
                        <p>Professional driver with over 5 years of experience. Known for punctuality and excellent service. Committed to providing safe and comfortable rides for all passengers.</p>
                        
                        <div class="mt-4">
                            <h5 class="mb-3">Languages</h5>
                            <span class="badge bg-primary me-2">English (Native)</span>
                            <span class="badge bg-primary me-2">Spanish (Conversational)</span>
                            <span class="badge bg-primary">French (Basic)</span>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="info-card">
                        <h3><i class="fas fa-car"></i> Vehicle Information</h3>
                        <div class="vehicle-info">
                            <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2" alt="Vehicle" class="vehicle-image">
                            <div>
                                <h5>Honda Accord 2022</h5>
                                <p class="mb-2">Silver • 4 Seats</p>
                                <span class="badge bg-success">Eco-Friendly</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p><i class="fas fa-check-circle text-success me-2"></i>Regular maintenance</p>
                            <p><i class="fas fa-check-circle text-success me-2"></i>Clean and sanitized</p>
                            <p><i class="fas fa-check-circle text-success me-2"></i>Air conditioning</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Reviews Section -->
                    <div class="info-card">
                        <h3><i class="fas fa-star"></i> Recent Reviews</h3>
                        <div class="review-item">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786" alt="Reviewer" class="reviewer-avatar">
                                <div>
                                    <h6 class="mb-1">Sarah Johnson</h6>
                                    <div class="rating">⭐⭐⭐⭐⭐</div>
                                </div>
                            </div>
                            <p class="mb-1">Amazing driver! Very professional and friendly. The car was clean and the ride was smooth.</p>
                            <small class="text-muted">2 days ago</small>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" alt="Reviewer" class="reviewer-avatar">
                                <div>
                                    <h6 class="mb-1">David Wilson</h6>
                                    <div class="rating">⭐⭐⭐⭐⭐</div>
                                </div>
                            </div>
                            <p class="mb-1">Punctual and very helpful with luggage. Great conversation during the ride!</p>
                            <small class="text-muted">1 week ago</small>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Reviewer" class="reviewer-avatar">
                                <div>
                                    <h6 class="mb-1">Emily Chen</h6>
                                    <div class="rating">⭐⭐⭐⭐⭐</div>
                                </div>
                            </div>
                            <p class="mb-1">Safe driver and very comfortable ride. Would definitely recommend!</p>
                            <small class="text-muted">2 weeks ago</small>
                        </div>
                    </div>

                    <!-- Achievements Section -->
                    <div class="info-card">
                        <h3><i class="fas fa-trophy"></i> Achievements</h3>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-medal fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Top Rated Driver</h6>
                                <small class="text-muted">Maintained 4.9+ rating for 3 months</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-award fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">100+ Rides Completed</h6>
                                <small class="text-muted">Milestone achieved in 2024</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-certificate fa-2x text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Perfect Attendance</h6>
                                <small class="text-muted">No cancellations in last 30 days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection