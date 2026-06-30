<?php

namespace App\Http\Controllers;

use App\Models\Clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Client_Controller extends Controller
{
    public function index()
    {
        return view('clients_list');
    }

    public function addedit()
    {
        return view('client_add_edit');
    }

    public function add(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_comp_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'mob' => 'required|string|max:15',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'register_by' => 'nullable|string|max:255',
            'updated_date' => 'nullable|date',
            'updated_by' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_delete' => 'boolean',
        ]);

        echo "<pre>";print_r($validatedData);exit;
        // Redirect to the clients list with a success message
        return redirect()->route('clients-list')->with('success', 'Client added successfully.');
    }
}
