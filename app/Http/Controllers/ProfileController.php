<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    /**
     * Show the user profile page with dynamic data
     */
    public function show(Request $request)
    {
        $token = Session::get('token');
        $user = Session::get('user');
        $profile = $user;
        $preferences = [];
        $emergencyContact = [];

        if ($token) {
            // Fetch latest user profile
            $profileResponse = Http::withToken($token)->get($this->apiBaseUrl . '/users/profile');
            if ($profileResponse->successful()) {
                $profile = $profileResponse->json()['user'] ?? $user;
            }
            // Fetch preferences
            $prefResponse = Http::withToken($token)->get($this->apiBaseUrl . '/user/preferences');
            if ($prefResponse->successful()) {
                $preferences = $prefResponse->json()['data'] ?? [];
            }
            // Fetch emergency contact
            $emergencyResponse = Http::withToken($token)->get($this->apiBaseUrl . '/user/emergency-contact');
            if ($emergencyResponse->successful()) {
                $emergencyContact = $emergencyResponse->json()['data'] ?? [];
            }
        }

        return view('user-profile', [
            'profile' => $profile,
            'preferences' => $preferences,
            'emergencyContact' => $emergencyContact,
        ]);
    }

    /**
     * Update user profile info
     */
    public function updateProfile(Request $request)
    {
        $token = Session::get('token');
        if (!$token) return back()->with('error', 'Not authenticated.');

        $data = $request->all();
        // Map frontend fields to API fields
        $data['name'] = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        $data['phone'] = $data['phone_number'] ?? '';
        unset($data['first_name'], $data['last_name'], $data['phone_number'], $data['email']);

        // Debug: log outgoing payload
        \Log::info('Profile update payload:', $data);

        $response = Http::withToken($token)->put($this->apiBaseUrl . '/users/profile', $data);

        // Debug: log API response
        \Log::info('Profile update API response:', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        if ($response->successful()) {
            // Optionally update session user
            $user = $response->json()['user'] ?? null;
            if ($user) Session::put('user', $user);
            return back()->with('success', 'Profile updated successfully!');
        }
        return back()->with('error', 'Failed to update profile.');
    }

    /**
     * Update user preferences
     */
    public function updatePreferences(Request $request)
    {
        $token = Session::get('token');
        if (!$token) return back()->with('error', 'Not authenticated.');

        $response = Http::withToken($token)->put($this->apiBaseUrl . '/user/preferences', $request->all());
        if ($response->successful()) {
            return back()->with('success', 'Preferences updated successfully!');
        }
        return back()->with('error', 'Failed to update preferences.');
    }

    /**
     * Update emergency contact
     */
    public function updateEmergencyContact(Request $request)
    {
        $token = Session::get('token');
        if (!$token) return back()->with('error', 'Not authenticated.');

        $response = Http::withToken($token)->put($this->apiBaseUrl . '/user/emergency-contact', $request->all());
        if ($response->successful()) {
            return back()->with('success', 'Emergency contact updated successfully!');
        }
        return back()->with('error', 'Failed to update emergency contact.');
    }
} 