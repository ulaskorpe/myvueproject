<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return inertia('Auth/Login');
    }




    public function store3(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate user
        if (!Auth::attempt($credentials, true)) {
            // Return a custom response with error code and message
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed. Please check your credentials.',
                'code' => 401, // Custom error code
            ], 401); // Send the custom status code
        }

        $request->session()->regenerate();

        // Return a success response with custom message and code
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful!',
            'redirect' => '/listing', // Optional: URL to redirect after success
            'code' => 200, // Custom success code
        ], 200); // Send the custom status code
    }

    public function store(Request $request)
    {
        if (
            !Auth::attempt($request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',

            ]), true)
        ) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();
        // return response()->json([
        //     'message' => 'Login succexxxxsful!',
        //     'redirect' => '/listing',
        // ]);
     //   return redirect()->intended('/listing');
     return redirect()->route('mylist')->with('success', 'Login successful!');
    //  return response()->json([
    //     'message' => 'Login successful!',
    //     'redirect' => url('/listing'),
    // ]);
   /// return redirect()->intended('/listing')->with('success', 'Login xxxxsuccessful!');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('listing.index');
    }
}
