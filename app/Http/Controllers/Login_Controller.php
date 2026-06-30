<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login_Controller extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required|string',
        ]);

        $post = $request->all();       


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            
            return json_encode(['success' => true, 'message' => 'Login successful.']);
        }

        return json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
}
