@extends('layouts.app') @section('My Profile - Hubber', 'profile page')
@section('style')
    <style>
        body {
            font-family: "Inter", sans-serif;
            background: white;
            min-height: 100vh;
        }

        .profile-container {
            min-height: 100vh;
            padding: 120px 0 2rem;
            position: relative;
        }

        .profile-container::before {
            display: none;
        }

        .main-card {
            background: white;
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.1);
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
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: left 0.6s ease;
        }

        .main-card:hover::before {
            left: 100%;
        }

        .page-title {
            color: var(--dark-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: none;
            text-align: center;
        }

        .page-subtitle {
            color: rgba(0, 0, 0, 0.7);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .profile-image-section {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            transition: all 0.3s ease;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .profile-image-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-image-upload:hover {
            transform: scale(1.1);
            background: #5a6fd8;
        }

        .profile-image-upload input[type="file"] {
            display: none;
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
            background: linear-gradient(135deg,
                    #5a6fd8,
                    var(--primary-color));
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .back-button {
            position: absolute;
            top: 80px; /* Move down to clear navbar */
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .main-card {
                margin: 1rem;
                padding: 2rem;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>
@endsection
@section('content')
@php
    $username = $profile['username'] ?? (isset($profile['email']) ? strstr($profile['email'], '@', true) : 'user');
@endphp
    <div class="profile-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="container">
            <div class="text-center mb-5">
                <h1 class="page-title">👤 My Profile</h1>
                <p class="page-subtitle">
                    Manage your account information and preferences
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="main-card">
                        <!-- Profile Photo Section -->
                        <div class="text-center mb-4">
                            <img src="{{ $profile['profile_photo_url'] ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuNhTZJTtkR6b-ADMhmzPvVwaLuLdz273wvQ&s' }}"
                                alt="Profile Photo" class="profile-avatar mb-3" />
                            <div>
                                <form action="#" method="POST" enctype="multipart/form-data" style="display:inline-block;">
                                    @csrf
                                    <label class="btn btn-outline-secondary me-2" style="margin-bottom:0;">
                                        <i class="fas fa-camera me-2"></i>Change Photo
                                        <input type="file" name="photo" style="display:none;" onchange="this.form.submit()" />
                                    </label>
                                </form>
                                <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash me-2"></i>Remove
                                    </button>
                                </form>
                            </div>
                            <h4 class="mt-3 mb-1" style="color: var(--dark-color)">
                                {{ $profile['first_name'] ?? '' }} {{ $profile['last_name'] ?? '' }}
                            </h4>
                            <p class="text-muted mb-3">
                                @{{ $username }} • Member since {{ isset($profile['member_since']) ? \Carbon\Carbon::parse($profile['member_since'])->format('Y') : '' }}
                            </p>
                        </div>

                        <!-- Personal Information -->
                        <div class="section-card">
                            <h5 class="mb-4">📝 Personal Information</h5>
                            <form class="row g-3" method="POST" action="{{ route('user.profile.update') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ $profile['first_name'] ?? '' }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ $profile['last_name'] ?? '' }}" required />
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ $profile['email'] ?? '' }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone_number" class="form-control" value="{{ $profile['phone_number'] ?? '' }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" value="{{ $profile['date_of_birth'] ?? '' }}" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $profile['address'] ?? '' }}" />
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Preferences -->
                        <div class="section-card">
                            <h5 class="mb-4">⚙️ Preferences</h5>
                            <form class="row g-3" method="POST" action="{{ route('user.profile.preferences') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Language</label>
                                    <select class="form-select" name="preferred_language">
                                        <option value="en" {{ ($preferences['preferred_language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="es" {{ ($preferences['preferred_language'] ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                                        <option value="fr" {{ ($preferences['preferred_language'] ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                                        <option value="de" {{ ($preferences['preferred_language'] ?? '') == 'de' ? 'selected' : '' }}>German</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select" name="currency">
                                        <option value="usd" {{ ($preferences['currency'] ?? '') == 'usd' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="eur" {{ ($preferences['currency'] ?? '') == 'eur' ? 'selected' : '' }}>EUR (€)</option>
                                        <option value="gbp" {{ ($preferences['currency'] ?? '') == 'gbp' ? 'selected' : '' }}>GBP (£)</option>
                                        <option value="cad" {{ ($preferences['currency'] ?? '') == 'cad' ? 'selected' : '' }}>CAD ($)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notification Preferences</label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="notification_preferences[email_notifications]" id="emailNotif" {{ ($preferences['notification_preferences']['email_notifications'] ?? false) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="emailNotif">
                                            📧 Email notifications for bookings
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="notification_preferences[sms_notifications]" id="smsNotif" {{ ($preferences['notification_preferences']['sms_notifications'] ?? false) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="smsNotif">
                                            📱 SMS notifications for ride updates
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="notification_preferences[promotional_emails]" id="promoNotif" {{ ($preferences['notification_preferences']['promotional_emails'] ?? false) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="promoNotif">
                                            🎉 Promotional offers and discounts
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Preferences
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="section-card">
                            <h5 class="mb-4">🚨 Emergency Contact</h5>
                            <form class="row g-3" method="POST" action="{{ route('user.profile.emergency') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $emergencyContact['name'] ?? '' }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Relationship</label>
                                    <select class="form-select" name="relationship" required>
                                        <option value="">Select relationship</option>
                                        <option value="spouse" {{ ($emergencyContact['relationship'] ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                        <option value="parent" {{ ($emergencyContact['relationship'] ?? '') == 'parent' ? 'selected' : '' }}>Parent</option>
                                        <option value="sibling" {{ ($emergencyContact['relationship'] ?? '') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                                        <option value="friend" {{ ($emergencyContact['relationship'] ?? '') == 'friend' ? 'selected' : '' }}>Friend</option>
                                        <option value="other" {{ ($emergencyContact['relationship'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Emergency Phone Number</label>
                                    <input type="tel" name="phone_number" class="form-control" value="{{ $emergencyContact['phone_number'] ?? '' }}" required />
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Emergency Contact
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Account Actions -->
                        <div class="section-card">
                            <h5 class="mb-4">🔐 Account Security</h5>
                            <div class="d-grid gap-2 d-md-flex">
                                <button class="btn btn-outline-primary me-md-2" onclick="changePassword()">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                                <button class="btn btn-outline-warning me-md-2" onclick="downloadData()">
                                    <i class="fas fa-download me-2"></i>Download My Data
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAccount()">
                                    <i class="fas fa-trash me-2"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateProfile(event) {
            event.preventDefault();
            alert("✅ Profile updated successfully!");
        }

        function updatePreferences(event) {
            event.preventDefault();
            alert("✅ Preferences saved successfully!");
        }

        function updateEmergencyContact(event) {
            event.preventDefault();
            alert("✅ Emergency contact updated successfully!");
        }

        function changePassword() {
            alert(
                "🔐 Password change feature - would redirect to secure password change form",
            );
        }

        function downloadData() {
            alert(
                "📥 Your data download has been initiated. You will receive an email with the download link.",
            );
        }

        function deleteAccount() {
            if (
                confirm(
                    "⚠️ Are you sure you want to delete your account? This action cannot be undone.",
                )
            ) {
                alert(
                    "Account deletion request submitted. You will receive a confirmation email.",
                );
            }
        }

        function updateProfilePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector(".profile-avatar").src =
                        e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
