<?php

namespace App\Http\Controllers;

use App\Models\{Clients,Companies};

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
        $companies = Companies::where('is_delete', 0)->where('status', 1)->get();
        return view('client_add_edit', compact('companies'));
    }

    public function add(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'company' => 'required|exists:companies,company_id',
            'email' => 'required|email|',//unique:clients,email',
            'phone' => 'required|string|max:15',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:500'
        ]);

        $post = $request->all();
        // echo "<pre>"; print_r($post); die;
        $is_saved = Clients::create([
            'client_name' => trim($post['client_name']),
            'company_id' => trim($post['company']),
            'email' => trim($post['email']),
            'mob' => trim($post['phone']),
            'dob' => $post['dob'] ?? null,
            'expected_revenue' => $post['revenue_expected'] ?? null,
            'address' => $post['address'] ?? null,
            'register_by' => session('user_id'), 
        ]);
        if (!$is_saved) {
            return json_encode(['status' => false, 'message' => 'Failed to add client. Please try again.']);
        }

        return json_encode(['status' => true, 'message' => 'Client added successfully.']);
    }

    public function clients_list(Request $request){

        $clients = Clients::with('company')->where('is_delete', 0)->get();
        $data = [];
        echo "<pre>"; print_r($clients); die;
    }
}
