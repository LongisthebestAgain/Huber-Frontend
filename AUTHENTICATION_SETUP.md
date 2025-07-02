# Hubber Frontend Authentication Setup

## Overview
Your frontend now uses Laravel controllers to communicate with your API for authentication instead of JavaScript localStorage. This provides better security and server-side session management.

## Configuration

1. **Set up your environment variables:**
   Create a `.env` file in your frontend directory and add:
   ```
   API_BASE_URL=http://127.0.0.1:8001/api
   ```
   Update the port number if your API runs on a different port.

2. **Make sure your API is running:**
   ```bash
   cd ../api
   php artisan serve --port=8001
   ```

3. **Start your frontend:**
   ```bash
   php artisan serve --port=8000
   ```

## How It Works

### Login Process
1. User submits login form at `/login`
2. `AuthController::login()` validates the form data
3. Controller makes HTTP request to API at `/api/login`
4. If successful, stores user data and token in Laravel session
5. Redirects user to home page

### Registration Process
1. User submits registration form at `/register`
2. `AuthController::register()` validates the form data
3. Controller makes HTTP request to API at `/api/register`
4. If successful, stores user data and token in Laravel session
5. Redirects user to home page

### Authentication Middleware
- Protects routes that require login (profile, bookings, etc.)
- Checks if user session exists
- Redirects to login if not authenticated

### Session Management
- User data stored in Laravel session, not localStorage
- Token included in session for API requests
- Logout clears all session data

## Testing the System

1. **Register a new user:**
   - Go to `http://127.0.0.1:8000/register`
   - Fill out the form (choose passenger or driver)
   - Submit and verify you're redirected to home page

2. **Login with existing credentials:**
   - Go to `http://127.0.0.1:8000/login`
   - Use the credentials you just created
   - Verify you're logged in (check navbar shows your name)

3. **Test protected routes:**
   - Try accessing `/profile` or `/bookings`
   - Should work when logged in
   - Should redirect to login when logged out

4. **Test logout:**
   - Click your name in the navbar → Logout
   - Should redirect to login page
   - Try accessing protected routes (should redirect to login)

## API Endpoints Used

- `POST /api/register` - User registration
- `POST /api/login` - User login  
- `POST /api/logout` - User logout
- `GET /api/user` - Get current user data

## Session Data Stored

- `user` - Complete user object from API
- `token` - Authentication token for API requests
- `user_role` - User role (passenger/driver)

## Error Handling

- Form validation errors are displayed on the same page
- API connection errors are handled gracefully
- Session expiration redirects to login

## Navbar Features

- Shows different menu based on authentication state
- Displays user's first name when logged in
- Shows driver-specific menu items for drivers
- Proper logout functionality with CSRF protection 