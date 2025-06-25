<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-car-side"></i> Hubber
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rides') }}">Available Rides</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        <i class="fas fa-user me-2"></i>Edit Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.bookings') }}">
                        <i class="fas fa-calendar-check me-2"></i>My Bookings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.history') }}">
                        <i class="fas fa-history me-2"></i>Ride History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary login-btn" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
