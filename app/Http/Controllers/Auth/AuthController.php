<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Handle login logic here
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            return response()->json(['message' => 'Login successful'], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Handle logout logic here
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
            
        return response()->json(['message' => 'Logout successful'], 200);
    }
}
