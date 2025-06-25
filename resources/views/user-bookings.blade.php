@extends('layouts.app') @section('My Bookings - Hubber', 'bookings page')
@section('style')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .bookings-container {
            min-height: 100vh;
            padding: 120px 0 2rem;
            position: relative;
        }

        .bookings-container::before {
            content: '';
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
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            text-align: center;
        }

        .page-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .booking-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }

        .booking-card:hover::before {
            left: 100%;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .route-info {
            position: relative;
            padding-left: 40px;
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

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-confirmed {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffd43b, #fab005);
            color: white;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, #339af0, #228be6);
            color: white;
        }

        .status-paid {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
        }

        .status-unpaid {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .payment-section {
            background: linear-gradient(135deg, rgba(76, 132, 255, 0.05), rgba(255, 255, 255, 0.8));
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid var(--primary-color);
        }

        .payment-section.paid {
            border-left-color: #51cf66;
            background: linear-gradient(135deg, rgba(81, 207, 102, 0.05), rgba(255, 255, 255, 0.8));
        }

        .payment-section.unpaid {
            border-left-color: #ff6b6b;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05), rgba(255, 255, 255, 0.8));
        }

        .btn-pay-now {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ee5a52, #ff6b6b);
            color: white;
        }

        .payment-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .payment-status.paid {
            color: #40c057;
        }

        .payment-status.unpaid {
            color: #ee5a52;
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
        }

        .btn-outline-danger {
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button {
            position: absolute;
            top: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .no-bookings {
            text-align: center;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filter-tabs {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .filter-tabs .nav-link {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .filter-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
            color: white;
        }

        @media (max-width: 768px) {
            .bookings-container {
                padding: 100px 1rem 2rem;
            }
            
            .page-title {
                font-size: 2rem;
            }

            .booking-card {
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
        }
    </style>
@endsection
@section('content')

    <div class="bookings-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="container">
            <div class="text-center mb-5">
                <h1 class="page-title">📅 My Bookings</h1>
                <p class="page-subtitle">View and manage your current ride bookings</p>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="filterBookings('all')">All Bookings</a>
                    </li>
                   
                    </li>
                </ul>
            </div>

            <!-- Upcoming Booking -->
            <div class="booking-card" data-status="confirmed" data-payment="paid">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="route-info">
                            <div class="route-point">
                                <small class="text-muted">📍 Pickup</small>
                                <div class="fw-bold">Central Station</div>
                                <small class="text-muted">Today at 14:30</small>
                            </div>
                            <div class="route-point">
                                <small class="text-muted">🎯 Destination</small>
                                <div class="fw-bold">Airport Terminal 1</div>
                                <small class="text-muted">Estimated arrival: 15:15</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="driver-info">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Driver" class="driver-avatar">
                            <div>
                                <div class="fw-bold">Michael Smith</div>
                                <small class="text-muted">⭐ 4.8 • Honda Accord</small>
                                <div class="text-primary"><i class="fas fa-phone me-1"></i> Contact Driver</div>
                            </div>
                        </div>
                        <div class="payment-section paid">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-success">$45.00</div>
                                    <small class="text-muted">2 seats booked</small>
                                </div>
                                <div class="payment-status paid">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Paid</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span class="status-badge status-confirmed">Confirmed</span>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-outline-danger btn-sm mb-2" onclick="cancelBooking(1)">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="viewDetails(1)">
                            <i class="fas fa-eye"></i> Details
                        </button>
                    </div>
                </div>
            </div>


            <!-- No Bookings Message (hidden by default) -->
            <div class="no-bookings" id="noBookingsMessage" style="display: none;">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No bookings found</h4>
                <p class="text-muted mb-4">You don't have any bookings yet. Start by finding available rides!</p>
                <a href="rides.html" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>Find Rides
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function payNow(bookingId, amount) {
            // Store booking details for payment page
            const bookingData = {
                bookingId: bookingId,
                amount: amount,
                returnUrl: 'user-bookings.html'
            };
            
            // Store in session storage for payment page to access
            sessionStorage.setItem('paymentData', JSON.stringify(bookingData));
            
            // Redirect to payment page
            window.location.href = 'payment-confirmation.html';
        }

        function filterBookings(status) {
            // Update active tab
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');

            // Filter booking cards
            const bookings = document.querySelectorAll('.booking-card');
            let visibleCount = 0;

            bookings.forEach(booking => {
                const bookingStatus = booking.getAttribute('data-status');
                const paymentStatus = booking.getAttribute('data-payment');
                
                if (status === 'all' || 
                    (status === 'upcoming' && (bookingStatus === 'confirmed')) ||
                    (status === 'pending' && bookingStatus === 'pending') ||
                    (status === 'unpaid' && paymentStatus === 'unpaid') ||
                    (status === 'cancelled' && bookingStatus === 'cancelled')) {
                    booking.style.display = 'block';
                    visibleCount++;
                } else {
                    booking.style.display = 'none';
                }
            });

            // Show/hide no bookings message
            document.getElementById('noBookingsMessage').style.display = 
                visibleCount === 0 ? 'block' : 'none';
        }

        function cancelBooking(bookingId) {
            if (confirm('⚠️ Are you sure you want to cancel this booking?')) {
                alert('🚫 Booking cancelled successfully. Refund will be processed within 3-5 business days.');
                // Here you would typically make an API call to cancel the booking
            }
        }

        function viewDetails(bookingId) {
            alert('📋 Booking details page would open here with full ride information, driver contact, and trip timeline.');
        }

        function rebookRide() {
            alert('🔄 Redirecting to similar rides for rebooking...');
            window.location.href = 'rides.html';
        }

        function goBack() {
            window.history.back();
        }
    </script>
@endsection
