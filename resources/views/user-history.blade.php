@extends('layouts.app') @section('Ride History - Hubber', 'history page')
@section('style')
    <style>
        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .history-container {
            min-height: 100vh;
            padding: 120px 0 2rem;
            position: relative;
        }

        .history-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .page-title {
            color: white;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .stats-overview {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-card {
            text-align: center;
            padding: 1.5rem;
            background: rgba(76, 132, 255, 0.05);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            background: rgba(76, 132, 255, 0.1);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .ride-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ride-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: left 0.6s ease;
        }

        .ride-card:hover::before {
            left: 100%;
        }

        .ride-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .route-info {
            position: relative;
            padding-left: 40px;
        }

        .route-info::before {
            content: "";
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg,
                    var(--primary-color),
                    #5a6fd8);
            border-radius: 2px;
        }

        .route-point {
            position: relative;
            margin-bottom: 1.5rem;
            background: rgba(76, 132, 255, 0.05);
            padding: 1rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .route-point::before {
            content: "";
            position: absolute;
            left: -42px;
            top: 50%;
            width: 12px;
            height: 12px;
            background: var(--primary-color);
            border-radius: 50%;
            transform: translateY(-50%);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .driver-info {
            background: rgba(76, 132, 255, 0.05);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .driver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .star-rating {
            color: #ffd700;
        }

        .btn-primary {
            background: linear-gradient(135deg,
                    var(--primary-color),
                    #5a6fd8);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 132, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 132, 255, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button {
            position: absolute;
            top: 110px;
            left: 20px;
            right: auto;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select {
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(76, 132, 255, 0.15);
            background: white;
        }

        .no-history {
            text-align: center;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .history-container {
                padding: 100px 1rem 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .ride-card {
                padding: 1.5rem;
            }

            .route-info {
                padding-left: 25px;
            }

            .route-point::before {
                left: -27px;
                width: 8px;
                height: 8px;
            }

            .stats-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
@section('content')
    <div class="history-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="container">
            <div class="text-center mb-5">
                <h1 class="page-title">📚 Ride History</h1>
                <p class="page-subtitle">
                    Your complete journey with Hubber
                </p>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number">23</div>
                            <div class="text-muted">Total Rides</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number">$567</div>
                            <div class="text-muted">Total Spent</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number">4.7</div>
                            <div class="text-muted">Avg Rating Given</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number">1,245</div>
                            <div class="text-muted">Miles Traveled</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select">
                            <option>All Time</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                            <option>This Year</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sort By</label>
                        <select class="form-select">
                            <option>Most Recent</option>
                            <option>Oldest First</option>
                            <option>Highest Rating</option>
                            <option>Price: High to Low</option>
                            <option>Price: Low to High</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" placeholder="🔍 Search by location, driver name..." />
                    </div>
                </div>
            </div>

            <!-- Ride History -->
            <div class="ride-card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="route-info">
                            <div class="route-point">
                                <small class="text-muted">📍 Pickup</small>
                                <div class="fw-bold">Central Station</div>
                                <small class="text-muted">Feb 14, 2024 at 14:30</small>
                            </div>
                            <div class="route-point">
                                <small class="text-muted">🎯 Destination</small>
                                <div class="fw-bold">
                                    Airport Terminal 1
                                </div>
                                <small class="text-muted">Arrived at 15:15</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="driver-info">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face"
                                alt="Driver" class="driver-avatar" />
                            <div>
                                <div class="fw-bold">Michael Smith</div>
                                <small class="text-muted">Honda Accord • Silver</small>
                                <div class="rating-display">
                                    <span class="star-rating">⭐⭐⭐⭐⭐</span>
                                    <small class="text-muted">Your rating</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="fw-bold text-success">$45.00</div>
                        <small class="text-muted">2 passengers</small>
                        <div class="mt-2">
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-outline-primary btn-sm mb-2" onclick="viewRideDetails(1)">
                            <i class="fas fa-eye"></i> Details
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="rebookSimilar(1)">
                            <i class="fas fa-redo"></i> Book Again
                        </button>
                    </div>
                </div>
            </div>

            <div class="ride-card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="route-info">
                            <div class="route-point">
                                <small class="text-muted">📍 Pickup</small>
                                <div class="fw-bold">Shopping Mall</div>
                                <small class="text-muted">Feb 12, 2024 at 16:00</small>
                            </div>
                            <div class="route-point">
                                <small class="text-muted">🎯 Destination</small>
                                <div class="fw-bold">University Campus</div>
                                <small class="text-muted">Arrived at 16:25</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="driver-info">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                alt="Driver" class="driver-avatar" />
                            <div>
                                <div class="fw-bold">David Wilson</div>
                                <small class="text-muted">Toyota Camry • Blue</small>
                                <div class="rating-display">
                                    <span class="star-rating">⭐⭐⭐⭐⭐</span>
                                    <small class="text-success">Reviewed</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="fw-bold text-success">$25.00</div>
                        <small class="text-muted">1 passenger</small>
                        <div class="mt-2">
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-outline-primary btn-sm mb-2" onclick="viewRideDetails(2)">
                            <i class="fas fa-eye"></i> Details
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="rebookSimilar(2)">
                            <i class="fas fa-redo"></i> Book Again
                        </button>
                    </div>
                </div>
            </div>

            <div class="ride-card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="route-info">
                            <div class="route-point">
                                <small class="text-muted">📍 Pickup</small>
                                <div class="fw-bold">Downtown Office</div>
                                <small class="text-muted">Feb 10, 2024 at 08:30</small>
                            </div>
                            <div class="route-point">
                                <small class="text-muted">🎯 Destination</small>
                                <div class="fw-bold">Sports Stadium</div>
                                <small class="text-muted">Arrived at 09:10</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="driver-info">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=50&h=50&fit=crop&crop=face"
                                alt="Driver" class="driver-avatar" />
                            <div>
                                <div class="fw-bold">Robert Johnson</div>
                                <small class="text-muted">BMW 3 Series • Black</small>
                                <div class="rating-display">
                                    <span class="star-rating">⭐⭐⭐⭐</span>
                                    <small class="text-muted">Good ride</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="fw-bold text-success">$35.00</div>
                        <small class="text-muted">1 passenger</small>
                        <div class="mt-2">
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-outline-primary btn-sm mb-2" onclick="viewRideDetails(3)">
                            <i class="fas fa-eye"></i> Details
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="rebookSimilar(3)">
                            <i class="fas fa-redo"></i> Book Again
                        </button>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary" onclick="loadMoreHistory()">
                    <i class="fas fa-plus me-2"></i>Load More Rides
                </button>
            </div>

            <!-- No History Message (hidden by default) -->
            <div class="no-history" id="noHistoryMessage" style="display: none">
                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No ride history yet</h4>
                <p class="text-muted mb-4">
                    Once you complete your first ride, it will appear here!
                </p>
                <a href="{{ route('rides') }}" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>Find Your First Ride
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewRideDetails(rideId) {
            alert(
                "📋 Detailed ride information would be displayed here including:\n\n• Complete route map\n• Driver information\n• Payment details\n• Receipt download\n• Trip timeline",
            );
        }

        function rebookSimilar(rideId) {
            alert(
                "🔄 Redirecting to find similar rides with the same route...",
            );
            window.location.href = "rides";
        }

        function loadMoreHistory() {
            alert("📥 Loading more ride history...");
            // Here you would typically load more data from the server
        }

        function goBack() {
            window.history.back();
        }

        // Initialize tooltips
        document.addEventListener("DOMContentLoaded", function() {
            // Add any initialization code here
        });
    </script>
@endsection
