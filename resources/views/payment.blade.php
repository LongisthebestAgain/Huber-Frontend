@extends('layouts.app') @section('Payment Huber', 'Payment Page')
@section('style')
    <style>
        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-method:hover {
            border-color: var(--primary-color);
            background-color: #f8f9ff;
        }
        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: #f8f9ff;
        }
        .payment-method input[type="radio"] {
            margin-right: 15px;
        }
        .ride-summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .price-breakdown {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .total-amount {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .back-button {
            position: absolute;
            top: 110px;
            left: 20px;
            right: auto;
            z-index: 10;
            background: linear-gradient(135deg, var(--primary-color), #5a6fd8);
            color: white;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(76, 132, 255, 0.15);
            padding: 0.8rem 1.2rem;
            font-size: 1.4rem;
            border: none;
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-button:hover {
            background: linear-gradient(135deg, #5a6fd8, var(--primary-color));
            color: #fffbe7;
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 8px 25px rgba(76, 132, 255, 0.25);
        }
    </style>
@endsection

@section('content')


    <div class="container" style="margin-top: 100px; margin-bottom: 50px;">
        <a href="{{ route('seat.selection') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="row">
            <!-- Payment Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-credit-card"></i> Payment Information</h4>
                        <p class="text-muted mb-0">Secure payment processing</p>
                    </div>
                    <div class="card-body">
                        <!-- Payment Methods -->
                        <div class="mb-4">
                            <h5>Choose Payment Method</h5>
                            
                            <!-- Credit/Debit Card -->
                            <div class="payment-method selected" data-method="card">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="paymentMethod" value="card" id="cardMethod" checked>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><i class="fas fa-credit-card text-primary"></i> Credit/Debit Card</h6>
                                        <small class="text-muted">Visa, MasterCard, American Express</small>
                                    </div>
                                    <div class="payment-icons">
                                        <i class="fab fa-cc-visa fa-2x text-primary me-2"></i>
                                        <i class="fab fa-cc-mastercard fa-2x text-warning me-2"></i>
                                        <i class="fab fa-cc-amex fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Wallet -->
                            <div class="payment-method" data-method="wallet">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="paymentMethod" value="wallet" id="walletMethod">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><i class="fas fa-mobile-alt text-success"></i> Mobile Wallet</h6>
                                        <small class="text-muted">ABA Pay, Wing, PayPal</small>
                                    </div>
                                    <div class="payment-icons">
                                        <span class="badge bg-success me-2">ABA</span>
                                        <span class="badge bg-warning me-2">Wing</span>
                                        <span class="badge bg-primary">PayPal</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="payment-method" data-method="bank">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="paymentMethod" value="bank" id="bankMethod">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><i class="fas fa-university text-info"></i> Bank Transfer</h6>
                                        <small class="text-muted">Direct bank account transfer</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Payment Form -->
                        <div id="cardPaymentForm" class="payment-form">
                            <h5>Card Information</h5>
                            <form>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="cardNumber" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="expiryDate" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="4">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="cardName" class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control" id="cardName" placeholder="John Doe">
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="saveCard">
                                    <label class="form-check-label" for="saveCard">
                                        Save this card for future payments
                                    </label>
                                </div>
                            </form>
                        </div>

                        <!-- Wallet Payment Form -->
                        <div id="walletPaymentForm" class="payment-form" style="display: none;">
                            <h5>Mobile Wallet</h5>
                            <div class="mb-3">
                                <label for="walletType" class="form-label">Select Wallet</label>
                                <select class="form-control" id="walletType">
                                    <option value="">Choose wallet...</option>
                                    <option value="aba">ABA Pay</option>
                                    <option value="wing">Wing</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="walletAccount" class="form-label">Account/Phone Number</label>
                                <input type="text" class="form-control" id="walletAccount" placeholder="Enter account or phone number">
                            </div>
                        </div>

                        <!-- Bank Transfer Form -->
                        <div id="bankPaymentForm" class="payment-form" style="display: none;">
                            <h5>Bank Transfer</h5>
                            <div class="alert alert-info">
                                <strong>Bank Transfer Instructions:</strong><br>
                                Transfer the amount to our bank account and payment will be confirmed within 24 hours.
                            </div>
                            <div class="bank-details p-3 bg-light rounded">
                                <h6>Bank Details:</h6>
                                <p><strong>Bank:</strong> ABC Bank</p>
                                <p><strong>Account Name:</strong> Hubber Ride Services</p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                                <p><strong>Reference:</strong> RIDE-2024-001</p>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="mt-4">
                            <h5>Billing Address</h5>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" value="John">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" value="Passenger">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="address" value="123 Main Street">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" value="New York">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control" id="state" value="NY">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zipCode" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control" id="zipCode" value="10001">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ride Summary Sidebar -->
            <div class="col-lg-4">
                <!-- Ride Summary -->
                <div class="ride-summary-card">
                    <h5><i class="fas fa-route"></i> Ride Summary</h5>
                    <div class="ride-route mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="route-dot bg-success me-3"></div>
                            <div>
                                <strong>Pickup</strong><br>
                                <small>123 Main Street, New York</small><br>
                                <small class="text-light">Dec 25, 2023 at 9:00 AM</small>
                            </div>
                        </div>
                        <div class="route-line"></div>
                        <div class="d-flex align-items-center">
                            <div class="route-dot bg-danger me-3"></div>
                            <div>
                                <strong>Drop-off</strong><br>
                                <small>456 Oak Avenue, Brooklyn</small><br>
                                <small class="text-light">Dec 25, 2023 at 10:30 AM</small>
                            </div>
                        </div>
                    </div>
                    <hr class="text-light">
                    <div class="ride-details">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Distance:</span>
                            <span>25.4 km</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Duration:</span>
                            <span>~1h 30m</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Ride Type:</span>
                            <span><span class="badge bg-light text-dark">Shared</span></span>
                        </div>
                    </div>
                </div>

                <!-- Driver Information -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6><i class="fas fa-user-tie"></i> Driver Information</h6>
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" class="rounded-circle me-3" width="60" height="60" alt="Driver">
                            <div>
                                <h6 class="mb-1">Mike Driver</h6>
                                <div class="rating mb-1">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <span class="ms-1">4.8</span>
                                </div>
                                <small class="text-muted">423 rides completed</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6><i class="fas fa-car"></i> Vehicle Information</h6>
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=80&h=60&fit=crop" class="rounded me-3" width="80" height="60" alt="Vehicle">
                            <div>
                                <h6 class="mb-1">2022 Toyota Camry</h6>
                                <small class="text-muted">Silver • ABC-1234</small><br>
                                <small class="text-muted">4 seats • A/C • Bluetooth</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="price-breakdown">
                    <h6><i class="fas fa-receipt"></i> Price Breakdown</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Base fare:</span>
                        <span>$15.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Distance (25.4 km × $0.80):</span>
                        <span>$20.32</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Time (1.5h × $5.00):</span>
                        <span>$7.50</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shared ride discount:</span>
                        <span class="text-success">-$8.60</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Service fee:</span>
                        <span>$2.50</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total Amount:</strong>
                        <strong class="total-amount">$36.72</strong>
                    </div>
                </div>

                <!-- Payment Actions -->
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary btn-lg" onclick="processPayment()">
                        <i class="fas fa-lock"></i> Pay Securely - $36.72
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="goBack()">
                        <i class="fas fa-arrow-left"></i> Back to Ride Selection
                    </button>
                </div>

                <!-- Security Info -->
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt text-success"></i>
                        Your payment is protected by SSL encryption
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div class="modal fade" id="paymentSuccessModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-success mb-3">Payment Successful!</h3>
                    <p class="mb-4">Your booking has been confirmed. You will receive a confirmation email shortly.</p>
                    
                    <div class="booking-details p-3 bg-light rounded mb-4">
                        <h6>Booking Details</h6>
                        <p class="mb-1"><strong>Booking ID:</strong> HUB-2024-001</p>
                        <p class="mb-1"><strong>Amount Paid:</strong> $36.72</p>
                        <p class="mb-0"><strong>Payment Method:</strong> **** 1234</p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" onclick="goToDashboard()">
                            Go to Dashboard
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="viewBooking()">
                            View Booking Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                
                // Add selected class to clicked method
                this.classList.add('selected');
                
                // Check the radio button
                this.querySelector('input[type="radio"]').checked = true;
                
                // Show/hide payment forms
                const selectedMethod = this.dataset.method;
                document.querySelectorAll('.payment-form').forEach(form => form.style.display = 'none');
                document.getElementById(selectedMethod + 'PaymentForm').style.display = 'block';
            });
        });

        // Card number formatting
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Expiry date formatting
        document.getElementById('expiryDate').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // CVV formatting
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/gi, '');
        });

        // Process payment
        function processPayment() {
            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            
            // Simulate payment processing
            const loadingBtn = document.querySelector('.btn-primary.btn-lg');
            loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            loadingBtn.disabled = true;

            setTimeout(() => {
                // Show success modal
                const modal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));
                modal.show();
                
                // Reset button
                loadingBtn.innerHTML = '<i class="fas fa-lock"></i> Pay Securely - $36.72';
                loadingBtn.disabled = false;
            }, 2000);
        }

        // Navigation functions
        function goBack() {
            window.location.href = 'rides';
        }

        function goToDashboard() {
            window.location.href = 'passenger-dashboard';
        }

        function viewBooking() {
            window.location.href = 'booking-history';
        }
    </script>

    <style>
        .route-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .route-line {
            width: 2px;
            height: 30px;
            background-color: rgba(255,255,255,0.3);
            margin-left: 18px;
            margin-bottom: 10px;
        }
    </style>

@endsection