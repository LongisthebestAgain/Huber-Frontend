@extends('layouts.app')
@section('Available Rides - Hubber', 'rides page')
@section('style')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: white;
            min-height: 100vh;
        }

        .rides-container {
            padding-top: 100px;
            min-height: 100vh;
            position: relative;
        }

        .rides-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .main-title {
            color: var(--dark-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: none;
        }

        .subtitle {
            color: rgba(0, 0, 0, 0.7);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 120px;
            height: fit-content;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border-radius: 20px;
            pointer-events: none;
        }

        .filter-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-title i {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .ride-type-selector {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .ride-type-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .ride-type-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 132, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .ride-type-option:hover::before {
            left: 100%;
        }

        .ride-type-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 132, 255, 0.2);
        }

        .ride-type-option.active {
            border-color: var(--primary-color);
            color: white;
            background: linear-gradient(135deg, rgba(76, 132, 255, 0.1), rgba(76, 132, 255, 0.05));
            box-shadow: 0 5px 15px rgba(76, 132, 255, 0.3);
        }

        .ride-type-option input {
            margin-right: 1rem;
            transform: scale(1.2);
            accent-color: var(--primary-color);
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

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
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
            background: linear-gradient(135deg, #5a6fd8, var(--primary-color));
        }

        .price-range {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .price-range span {
            color: var(--primary-color);
            font-weight: 600;
        }

        .ride-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            position: relative;
        }

        .ride-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .ride-card:hover::before {
            left: 100%;
        }

        .ride-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .driver-info {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .driver-info:hover {
            transform: translateX(5px);
        }

        .driver-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 1.5rem;
            object-fit: cover;
            border: 4px solid rgba(76, 132, 255, 0.2);
            transition: all 0.3s ease;
        }

        .ride-card:hover .driver-avatar {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .route-info {
            position: relative;
            padding-left: 40px;
            margin-bottom: 1.5rem;
        }

        .route-info::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--primary-color), #5a6fd8);
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
            content: '';
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

        .route-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .ride-card:hover .route-image {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .ride-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(76, 132, 255, 0.08);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: rgba(76, 132, 255, 0.15);
            transform: translateY(-2px);
        }

        .detail-item i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .ride-type-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .exclusive {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .shared {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
        }

        .rating-stars {
            color: #ffd43b;
            font-size: 1.1rem;
            margin-right: 0.5rem;
        }

        .no-rides {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .no-rides i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .mobile-filters {
            display: none;
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
            border: none;
            border-radius: 15px;
            padding: 1rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(76, 132, 255, 0.3);
        }

        .mobile-filters:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 132, 255, 0.4);
        }

        .ride-count {
            background: var(--primary-color);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            border: none;
        }

        .search-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .stagger-4 {
            animation-delay: 0.4s;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
                margin-bottom: 2rem;
            }

            .mobile-filters {
                display: block;
                margin-bottom: 1rem;
            }

            .ride-details {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .ride-details .btn {
                width: 100%;
            }

            .main-title {
                font-size: 2rem;
            }

            .driver-avatar {
                width: 60px;
                height: 60px;
            }

            .route-info {
                padding-left: 30px;
            }

            .route-point::before {
                left: -32px;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .back-button {
            position: absolute;
            top: 80px; 
            left: 30px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
            color: #fff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(76, 132, 255, 0.18);
            font-size: 1.5rem;
            transition: box-shadow 0.2s, background 0.2s, transform 0.2s;
            cursor: pointer;
            outline: none;
            text-decoration: none;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #5a6fd8, var(--primary-color));
            box-shadow: 0 8px 32px rgba(76, 132, 255, 0.28);
            transform: translateY(-2px) scale(1.05);
            color: #fff;
        }

        .back-button i {
            margin: 0;
        }

        @media (max-width: 768px) {
            .back-button {
                top: 60px; /* Also move down on mobile */
                left: 16px;
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>
@endsection
@section('content')
    <div class="rides-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="text-center mb-5 fadeInUp">
                <h1 class="main-title">Find Your Perfect Ride</h1>
                <p class="subtitle">Discover comfortable and affordable rides to your destination</p>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Mobile Filter Toggle -->
                    <button class="btn btn-primary w-100 mobile-filters" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filtersCollapse">
                        <i class="fas fa-filter me-2"></i> Show Filters
                    </button>

                    <div class="sidebar collapse show fadeInUp stagger-1" id="filtersCollapse">
                        <!-- Search Box -->
                        <div class="filter-section">
                            <h5 class="filter-title">
                                <i class="fas fa-search"></i>
                                Search Routes
                            </h5>
                            <form id="searchForm" onsubmit="searchRides(event)">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="fromLocation"
                                        placeholder="📍 From location">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="toLocation" placeholder="🎯 To location">
                                </div>
                                <div class="mb-3">
                                    <input type="date" class="form-control" id="rideDate">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i> Search Rides
                                </button>
                            </form>
                        </div>

                        <!-- Ride Type Filter -->
                        <div class="filter-section">
                            <h5 class="filter-title">
                                <i class="fas fa-car"></i>
                                Ride Type
                            </h5>
                            <div class="ride-type-selector">
                                <label class="ride-type-option active">
                                    <input type="radio" name="rideType" value="all" checked onchange="filterRides()">
                                    <div>
                                        <strong>🚗 All Rides</strong>
                                        <small class="text-muted d-block">Show all available rides</small>
                                    </div>
                                </label>
                                <label class="ride-type-option">
                                    <input type="radio" name="rideType" value="shared" onchange="filterRides()">
                                    <div>
                                        <strong>👥 Shared Ride</strong>
                                        <small class="text-muted d-block">Share with other passengers</small>
                                    </div>
                                </label>
                                <label class="ride-type-option">
                                    <input type="radio" name="rideType" value="exclusive" onchange="filterRides()">
                                    <div>
                                        <strong>👑 Exclusive Ride</strong>
                                        <small class="text-muted d-block">Private ride for you only</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="filter-section">
                            <h5 class="filter-title">
                                <i class="fas fa-dollar-sign"></i>
                                Price Range (USD)
                            </h5>
                            <div class="price-range">
                                <input type="number" class="form-control" placeholder="Min" id="minPrice"
                                    onchange="filterRides()">
                                <span>—</span>
                                <input type="number" class="form-control" placeholder="Max" id="maxPrice"
                                    onchange="filterRides()">
                            </div>
                        </div>

                        <!-- Departure Time -->
                        <div class="filter-section">
                            <h5 class="filter-title">
                                <i class="fas fa-clock"></i>
                                Departure Time
                            </h5>
                            <select class="form-select" id="timeFilter" onchange="filterRides()">
                                <option value="">🕐 Any Time</option>
                                <option value="morning">🌅 Morning (6-12)</option>
                                <option value="afternoon">☀️ Afternoon (12-18)</option>
                                <option value="evening">🌆 Evening (18-24)</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="filter-section">
                            <h5 class="filter-title">
                                <i class="fas fa-sort"></i>
                                Sort By
                            </h5>
                            <select class="form-select" id="sortBy" onchange="filterRides()">
                                <option value="price_low">💰 Price: Low to High</option>
                                <option value="price_high">💎 Price: High to Low</option>
                                <option value="time_early">⏰ Time: Earliest</option>
                                <option value="rating">⭐ Rating: Highest</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4 fadeInUp stagger-2">
                        <h4 style="color: var(--dark-color)">Available Rides</h4>
                        <span id="rideCount" class="ride-count">0 rides found</span>
                    </div>

                    <!-- Results Section -->
                    <div id="searchResults" class="fadeInUp stagger-3">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let allRides = [];

        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('rideDate').min = today;
            document.getElementById('rideDate').value = today;

            // Add event listeners for radio buttons
            document.querySelectorAll('input[name="rideType"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.ride-type-option').forEach(option => {
                        option.classList.remove('active');
                    });
                    this.closest('.ride-type-option').classList.add('active');
                });
            });

            // Initialize rides data
            initializeRides();
            showAvailableRides();
        });

        function initializeRides() {
            // Sample rides data with Khmer names and locations
            allRides = [{
                    id: 1,
                    driver: "សុខា ចាន់ (Sokha Chan)",
                    rating: 4.8,
                    from: "ផ្សារធំថ្មី (Phsar Thmei)",
                    to: "អាកាសយានដ្ឋានអន្តរជាតិភ្នំពេញ (Phnom Penh Airport)",
                    driverImage: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face",
                    routeImage: "https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=400&h=120&fit=crop",
                    date: "",
                    time: "09:00 AM",
                    car: "Toyota Camry (White)",
                    seats: 3,
                    price: 25,
                    type: "shared"
                },
                {
                    id: 2,
                    driver: "រតនា គឹម (Ratana Kim)",
                    rating: 4.9,
                    from: "អូលីម្ពិចម៉ាកេត (Olympic Market)",
                    driverImage: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face",
                    to: "សាកលវិទ្យាល័យភូមិន្ទភ្នំពេញ (Royal University)",
                    routeImage: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=120&fit=crop",

                    date: "",
                    time: "10:30 AM",
                    car: "Honda Civic (Silver)",
                    seats: 2,
                    price: 18,
                    type: "shared"
                },
                {
                    id: 3,
                    driver: "វិចិត្រ ពេជ្រ (Vichit Pich)",
                    driverImage: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face",
                    rating: 4.7,
                    from: "ស្ពានជប៉ុន (Japanese Bridge)",
                    to: "សៀមរាប (Siem Reap)",
                    routeImage: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=120&fit=crop",

                    date: "",
                    time: "07:00 AM",
                    car: "Toyota Highlander (Black)",
                    seats: 1,
                    price: 45,
                    type: "exclusive"
                },
                {
                    id: 4,
                    driver: "សោភា ហេង (Sophea Heng)",
                    driverImage: "https://images.unsplash.com/photo-1580489944761-15a19d654956?w=150&h=150&fit=crop&crop=face",
                    rating: 4.6,
                    from: "កោះពេជ្រ (Koh Pich)",
                    to: "កំពង់ចាម (Kampong Cham)",
                    routeImage: "https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=400&h=120&fit=crop",
                    date: "",
                    time: "14:00 PM",
                    car: "Hyundai Tucson (Blue)",
                    seats: 4,
                    price: 35,
                    type: "shared"
                },
                {
                    id: 5,
                    driver: "ពិសាច ដា (Pisach Da)",
                    driverImage: "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&crop=face",
                    rating: 4.5,
                    from: "វត្តភ្នំ (Wat Phnom)",
                    to: "កំពត (Kampot)",
                    routeImage: "https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=400&h=120&fit=crop",
                    date: "",
                    time: "11:30 AM",
                    car: "Ford Everest (White)",
                    seats: 1,
                    price: 50,
                    type: "exclusive"
                }
            ];

            // Set current date for all rides
            const currentDate = document.getElementById('rideDate').value;
            allRides.forEach(ride => {
                ride.date = currentDate;
            });
        }

        function searchRides(event) {
            event.preventDefault();

            // Add loading state
            const button = event.target.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Searching...';
            button.disabled = true;

            setTimeout(() => {
                filterRides();
                button.innerHTML = originalText;
                button.disabled = false;
            }, 1000);
        }

        function filterRides() {
            const rideType = document.querySelector('input[name="rideType"]:checked').value;
            const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
            const timeFilter = document.getElementById('timeFilter').value;
            const sortBy = document.getElementById('sortBy').value;

            let filteredRides = allRides.filter(ride => {
                // Filter by ride type
                if (rideType !== 'all' && ride.type !== rideType) return false;

                // Filter by price
                if (ride.price < minPrice || ride.price > maxPrice) return false;

                // Filter by time
                if (timeFilter) {
                    const hour = parseInt(ride.time.split(':')[0]);
                    const isPM = ride.time.includes('PM');
                    const hour24 = isPM && hour !== 12 ? hour + 12 : hour;

                    switch (timeFilter) {
                        case 'morning':
                            if (hour24 < 6 || hour24 >= 12) return false;
                            break;
                        case 'afternoon':
                            if (hour24 < 12 || hour24 >= 18) return false;
                            break;
                        case 'evening':
                            if (hour24 < 18 || hour24 >= 24) return false;
                            break;
                    }
                }

                return true;
            });

            // Sort rides
            filteredRides.sort((a, b) => {
                switch (sortBy) {
                    case 'price_low':
                        return a.price - b.price;
                    case 'price_high':
                        return b.price - a.price;
                    case 'time_early':
                        return a.time.localeCompare(b.time);
                    case 'rating':
                        return b.rating - a.rating;
                    default:
                        return 0;
                }
            });

            showAvailableRides(filteredRides);
        }

        function showAvailableRides(rides = allRides) {
            const resultsContainer = document.getElementById('searchResults');
            const rideCount = document.getElementById('rideCount');

            rideCount.textContent = `${rides.length} rides found`;

            if (rides.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="no-rides">
                        <i class="fas fa-car-side"></i>
                        <h4>No Rides Available</h4>
                        <p class="text-muted">Try different search criteria or check back later for more options.</p>
                        <button class="btn btn-primary mt-3" onclick="resetFilters()">
                            <i class="fas fa-refresh me-2"></i>Reset Filters
                        </button>
                    </div>
                `;
                return;
            }

            resultsContainer.innerHTML = rides.map((ride, index) => `
                <div class="ride-card fadeInUp" style="animation-delay: ${index * 0.1}s">
                    <img src="${ride.routeImage}" alt="Route" class="route-image">
                    <div class="driver-info" onclick="goToDriverProfile(${ride.id})" style="cursor:pointer;">
                        <img src="${ride.driverImage}" alt="${ride.driver}" class="driver-avatar">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">${ride.driver}</h5>
                                    <div class="rating-stars">
                                        ${"★".repeat(Math.floor(ride.rating))}${ride.rating % 1 ? "☆" : ""}
                                        <small class="text-muted">(${ride.rating})</small>
                                    </div>
                                </div>
                                <span class="ride-type-badge ${ride.type}">
                                    ${ride.type === 'shared' ? '👥 Shared' : '👑 Exclusive'}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="route-info">
                        <div class="route-point">
                            <small class="text-muted fw-bold">📍 PICKUP</small>
                            <div class="fw-semibold">${ride.from}</div>
                            <small class="text-primary">📅 ${ride.date} • 🕐 ${ride.time}</small>
                        </div>
                        <div class="route-point">
                            <small class="text-muted fw-bold">🎯 DROPOFF</small>
                            <div class="fw-semibold">${ride.to}</div>
                        </div>
                    </div>
                    <div class="ride-details">
                        <div class="detail-item">
                            <i class="fas fa-car"></i>
                            <span>${ride.car}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <span>${ride.seats} seats available</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="h5 mb-0 fw-bold">$${ride.price}</span>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-primary px-4" onclick="bookRide(${ride.id})">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function resetFilters() {
            // Reset all form inputs
            document.getElementById('fromLocation').value = '';
            document.getElementById('toLocation').value = '';
            document.getElementById('minPrice').value = '';
            document.getElementById('maxPrice').value = '';
            document.getElementById('timeFilter').value = '';
            document.getElementById('sortBy').value = 'price_low';

            // Reset ride type to "all"
            document.querySelector('input[value="all"]').checked = true;
            document.querySelectorAll('.ride-type-option').forEach(option => {
                option.classList.remove('active');
            });
            document.querySelector('input[value="all"]').closest('.ride-type-option').classList.add('active');

            // Show all rides
            showAvailableRides();
        }

        function bookRide(rideId) {
            // Find the ride details
            const ride = allRides.find(r => r.id === rideId);

            // Add some visual feedback
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Processing...';
            button.disabled = true;

            setTimeout(() => {
                // Store ride details in sessionStorage for the next page
                sessionStorage.setItem('selectedRide', JSON.stringify(ride));

                // Different flows based on ride type
                if (ride.type === 'exclusive') {
                    // Exclusive booking goes directly to payment
                    window.location.href = "{{ route('payment') }}";
                } else {
                    // Shared booking goes to seat selection first
                    window.location.href = "{{ route('seat.selection') }}";
                }
            }, 1000);
        }

        function goToDriverProfile(rideId) {
            // Optionally, store ride/driver info for the profile page
            const ride = allRides.find(r => r.id === rideId);
            sessionStorage.setItem('selectedDriver', JSON.stringify(ride));
            window.location.href = "{{ route('driver.profile') }}";
        }
    </script>
@endsection
