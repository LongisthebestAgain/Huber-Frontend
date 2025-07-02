<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        // Configure your API base URL here
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'user_role' => 'required|in:passenger,driver'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Make API call to login
            $response = Http::post($this->apiBaseUrl . '/login', [
                'email' => $request->email,
                'password' => $request->password,
                'user_role' => $request->user_role
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store user data and token in session
                Session::put('user', $data['user']);
                Session::put('token', $data['token']);
                Session::put('user_role', $data['user']['user_role']);

                return redirect()->route('home')->with('success', 'Login successful!');
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Login failed. Please try again.';
                
                return back()->withErrors(['login' => $errorMessage])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Unable to connect to the server. Please try again later.'])->withInput();
        }
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed',
            'user_role' => 'required|in:passenger,driver',
            'phone_number' => 'required|string|max:20',
        ];

        // Add driver-specific validation
        if ($request->user_role === 'driver') {
            $rules['license_number'] = 'required|string|max:50';
            $rules['vehicle_info'] = 'required|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $registrationData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'user_role' => $request->user_role,
                'phone_number' => $request->phone_number,
            ];

            // Add driver-specific data
            if ($request->user_role === 'driver') {
                $registrationData['license_number'] = $request->license_number;
                $registrationData['vehicle_info'] = $request->vehicle_info;
            }

            // Make API call to register
            $response = Http::post($this->apiBaseUrl . '/register', $registrationData);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store user data and token in session
                Session::put('user', $data['user']);
                Session::put('token', $data['token']);
                Session::put('user_role', $data['user']['user_role']);

                return redirect()->route('home')->with('success', 'Registration successful! Welcome to Huber!');
            } else {
                $errorData = $response->json();
                
                if (isset($errorData['errors'])) {
                    return back()->withErrors($errorData['errors'])->withInput();
                } else {
                    $errorMessage = $errorData['message'] ?? 'Registration failed. Please try again.';
                    return back()->withErrors(['registration' => $errorMessage])->withInput();
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['registration' => 'Unable to connect to the server. Please try again later.'])->withInput();
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        try {
            $token = Session::get('token');
            
            if ($token) {
                // Make API call to logout
                Http::withToken($token)->post($this->apiBaseUrl . '/logout');
            }
        } catch (\Exception $e) {
            // Continue with logout even if API call fails
        }

        // Clear session
        Session::forget(['user', 'token', 'user_role']);
        Session::flush();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get current user data
     */
    public function getCurrentUser()
    {
        $token = Session::get('token');
        
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withToken($token)->get($this->apiBaseUrl . '/user');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // Token might be expired, clear session
            Session::forget(['user', 'token', 'user_role']);
        }

        return null;
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $response = Http::post($this->apiBaseUrl . '/forgot-password', [
                'email' => $request->email
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Password reset link sent to your email.');
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Unable to send reset email.';
                return back()->withErrors(['email' => $errorMessage]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Unable to connect to the server. Please try again later.']);
        }
    }
} 