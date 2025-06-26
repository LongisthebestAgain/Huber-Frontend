@extends('layouts.app') @section('Seat Selection Huber', 'Seat Selection Page')
@section('style')
        <style>
            body {
                font-family: "Inter", sans-serif;
                min-height: 100vh;
            }

            .seat-container {
                min-height: 100vh;
                padding: 2rem 0;
                position: relative;
            }

            .seat-container::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                pointer-events: none;
            }

            .main-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: 25px;
                padding: 3rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }

            .main-card::before {
                content: "";
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                    90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent
                );
                transition: left 0.6s ease;
            }

            .page-title {
                color: gray;
                font-weight: 700;
                font-size: 2.5rem;
                margin-top: 2.5rem;
                margin-bottom: 0.5rem;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                text-align: center;
            }

            .page-subtitle {
                color: gray;
                font-size: 1.1rem;
                margin-bottom: 3rem;
                text-align: center;
            }

            .ride-summary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 20px;
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .vehicle-layout {
                background: #f8f9fa;
                border-radius: 20px;
                padding: 2rem;
                margin: 2rem 0;
                position: relative;
            }

            .vehicle-outline {
                max-width: 300px;
                margin: 0 auto;
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .driver-area {
                text-align: center;
                margin-bottom: 1rem;
                padding: 0.5rem;
                background: rgba(76, 132, 255, 0.1);
                border-radius: 10px;
            }

            .seats-grid {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                gap: 1rem;
                align-items: center;
            }

            .seat {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                border: 3px solid #ddd;
                background: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 1.2rem;
                position: relative;
            }

            .seat.available {
                background: white;
                border-color: #28a745;
                color: #28a745;
            }

            .seat.available:hover {
                background: #28a745;
                color: white;
                transform: scale(1.1);
                box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            }

            .seat.selected {
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-color: #667eea;
                color: white;
                transform: scale(1.1);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .seat.occupied {
                background: #dc3545;
                border-color: #dc3545;
                color: white;
                cursor: not-allowed;
            }

            .seat-legend {
                display: flex;
                justify-content: center;
                gap: 2rem;
                margin-top: 1.5rem;
                flex-wrap: wrap;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.9rem;
            }

            .legend-seat {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                border: 2px solid;
            }

            .pricing-summary {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                padding: 2rem;
                margin-top: 2rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea, #764ba2);
                border: none;
                border-radius: 12px;
                padding: 1rem 2rem;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            }

            .btn-primary:disabled {
                background: #6c757d;
                transform: none;
                box-shadow: none;
            }

            .btn-outline-secondary {
                border: 2px solid #6c757d;
                border-radius: 12px;
                padding: 1rem 2rem;
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

            .selection-count {
                background: linear-gradient(135deg, #51cf66, #40c057);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            @media (max-width: 768px) {
                .main-card {
                    margin: 1rem;
                    padding: 2rem;
                }

                .page-title {
                    font-size: 2rem;
                }

                .seats-grid {
                    gap: 0.5rem;
                }

                .seat {
                    width: 40px;
                    height: 40px;
                }
            }
        </style>
@endsection

@section('content')

        <div class="seat-container">
            <a href="{{ route('rides') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="page-title">🪑 Select Your Seats</h1>
                    <p class="page-subtitle">
                        Choose your preferred seats for the shared ride
                    </p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="main-card">
                            <!-- Ride Summary -->
                            <div class="ride-summary" id="rideSummary">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-2">
                                            📍 <span id="routeFrom"></span> →
                                            <span id="routeTo"></span>
                                        </h5>
                                        <p class="mb-1">
                                            👤 <span id="driverName"></span> •
                                            ⭐ <span id="driverRating"></span>
                                        </p>
                                        <p class="mb-0">
                                            📅 <span id="rideDate"></span> • 🕐
                                            <span id="rideTime"></span>
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div
                                            class="selection-count"
                                            id="selectionCount"
                                            style="display: none"
                                        >
                                            <i class="fas fa-check-circle"></i>
                                            <span>0 seats selected</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Layout -->
                            <div class="vehicle-layout">
                                <h6 class="text-center mb-3">
                                    🚗 Vehicle Layout
                                </h6>
                                <div class="vehicle-outline">
                                    <div class="driver-area">
                                        <i class="fas fa-steering-wheel"></i>
                                        <small class="d-block">Driver</small>
                                    </div>

                                    <div class="seats-grid">
                                        <!-- Row 1 -->
                                        <div
                                            class="seat available"
                                            data-seat="1"
                                            onclick="selectSeat(1)"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <div
                                            style="
                                                text-align: center;
                                                color: #6c757d;
                                            "
                                        >
                                            <small>Aisle</small>
                                        </div>
                                        <div
                                            class="seat occupied"
                                            data-seat="2"
                                        >
                                            <i class="fas fa-user"></i>
                                        </div>

                                        <!-- Row 2 -->
                                        <div
                                            class="seat available"
                                            data-seat="3"
                                            onclick="selectSeat(3)"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <div></div>
                                        <div
                                            class="seat available"
                                            data-seat="4"
                                            onclick="selectSeat(4)"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                        </div>

                                        <!-- Row 3 -->
                                        <div
                                            class="seat occupied"
                                            data-seat="5"
                                        >
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div></div>
                                        <div
                                            class="seat available"
                                            data-seat="6"
                                            onclick="selectSeat(6)"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seat Legend -->
                                <div class="seat-legend">
                                    <div class="legend-item">
                                        <div
                                            class="legend-seat"
                                            style="
                                                background: white;
                                                border-color: #28a745;
                                                color: #28a745;
                                            "
                                        ></div>
                                        <span>Available</span>
                                    </div>
                                    <div class="legend-item">
                                        <div
                                            class="legend-seat"
                                            style="
                                                background: linear-gradient(
                                                    135deg,
                                                    #667eea,
                                                    #764ba2
                                                );
                                                border-color: #667eea;
                                            "
                                        ></div>
                                        <span>Selected</span>
                                    </div>
                                    <div class="legend-item">
                                        <div
                                            class="legend-seat"
                                            style="
                                                background: #dc3545;
                                                border-color: #dc3545;
                                            "
                                        ></div>
                                        <span>Occupied</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Summary -->
                            <div class="pricing-summary">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6 class="mb-2">💰 Pricing Summary</h6>
                                        <div
                                            class="d-flex justify-content-between"
                                        >
                                            <span>Price per seat:</span>
                                            <strong id="pricePerSeat"
                                                >$0</strong
                                            >
                                        </div>
                                        <div
                                            class="d-flex justify-content-between"
                                        >
                                            <span>Selected seats:</span>
                                            <strong id="selectedSeatsCount"
                                                >0</strong
                                            >
                                        </div>
                                        <hr />
                                        <div
                                            class="d-flex justify-content-between"
                                        >
                                            <span class="h6">Total:</span>
                                            <span
                                                class="h5 text-primary"
                                                id="totalAmount"
                                                >$0</span
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button
                                            class="btn btn-primary"
                                            id="proceedBtn"
                                            onclick="proceedToPayment()"
                                            disabled
                                        >
                                            <i
                                                class="fas fa-credit-card me-2"
                                            ></i
                                            >Proceed to Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            let selectedRide = null;
            let selectedSeats = [];

            // Load ride data when page loads
            document.addEventListener("DOMContentLoaded", function () {
                loadRideData();
            });

            function loadRideData() {
                // Get ride data from sessionStorage
                const rideData = sessionStorage.getItem("selectedRide");
                if (!rideData) {
                    alert("No ride selected. Redirecting back to rides page.");
                    window.location.href = "rides.html";
                    return;
                }

                selectedRide = JSON.parse(rideData);
                displayRideInfo();
            }

            function displayRideInfo() {
                document.getElementById("routeFrom").textContent =
                    selectedRide.from;
                document.getElementById("routeTo").textContent =
                    selectedRide.to;
                document.getElementById("driverName").textContent =
                    selectedRide.driver;
                document.getElementById("driverRating").textContent =
                    selectedRide.rating;
                document.getElementById("rideDate").textContent =
                    selectedRide.date;
                document.getElementById("rideTime").textContent =
                    selectedRide.time;
                document.getElementById("pricePerSeat").textContent =
                    `$${selectedRide.price}`;
            }

            function selectSeat(seatNumber) {
                const seatElement = document.querySelector(
                    `[data-seat="${seatNumber}"]`,
                );

                if (seatElement.classList.contains("occupied")) {
                    return; // Can't select occupied seats
                }

                if (seatElement.classList.contains("selected")) {
                    // Deselect seat
                    seatElement.classList.remove("selected");
                    seatElement.classList.add("available");
                    seatElement.innerHTML = '<i class="fas fa-user-plus"></i>';
                    selectedSeats = selectedSeats.filter(
                        (seat) => seat !== seatNumber,
                    );
                } else {
                    // Select seat
                    seatElement.classList.remove("available");
                    seatElement.classList.add("selected");
                    seatElement.innerHTML = '<i class="fas fa-check"></i>';
                    selectedSeats.push(seatNumber);
                }

                updatePricingSummary();
            }

            function updatePricingSummary() {
                const count = selectedSeats.length;
                const pricePerSeat = selectedRide.price;
                const total = count * pricePerSeat;

                document.getElementById("selectedSeatsCount").textContent =
                    count;
                document.getElementById("totalAmount").textContent =
                    `$${total}`;

                // Update selection counter
                const selectionCount =
                    document.getElementById("selectionCount");
                if (count > 0) {
                    selectionCount.style.display = "inline-flex";
                    selectionCount.querySelector("span").textContent =
                        `${count} seat${count > 1 ? "s" : ""} selected`;
                    document.getElementById("proceedBtn").disabled = false;
                } else {
                    selectionCount.style.display = "none";
                    document.getElementById("proceedBtn").disabled = true;
                }
            }

            function proceedToPayment() {
                if (selectedSeats.length === 0) {
                    alert("Please select at least one seat.");
                    return;
                }

                // Add selected seats to ride data
                selectedRide.selectedSeats = selectedSeats;
                selectedRide.totalAmount =
                    selectedSeats.length * selectedRide.price;

                // Store updated ride data
                sessionStorage.setItem(
                    "selectedRide",
                    JSON.stringify(selectedRide),
                );

                // Redirect to payment
                window.location.href = "payment-confirmation.html";
            }
        </script>
@endsection
