<?php

namespace App\Http\Controllers;

use App\Models\{Clients,Companies};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Client_Controller extends Controller
{
    public function index()
    {
        return view('masters.clients_list');
    }

    public function addedit($client_id = "")
    {
        if(!empty($client_id)){
            $client = Clients::where('client_id', $client_id)
                ->where('is_delete', 0)
                ->first();
            if(!$client){
                return redirect()->route('clients')->with('error', 'Client not found.');
            }
        } else {
            $client = [];
        }
        
        // echo "<pre>"; print_r($client); die;

        $companies = Companies::where('is_delete', 0)->where('status', 1)->get();

        return view('masters.client_add_edit', compact('companies','client'));
    }

    public function add_update(Request $request)
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
        if(!empty($post['client_id'])){
            $is_updated = Clients::where('client_id', $post['client_id'])->update([
                'client_name' => trim($post['client_name']),
                'company_id' => trim($post['company']),
                'email' => trim($post['email']),
                'mob' => trim($post['phone']),
                'dob' => $post['dob'] ?? null,
                'expected_revenue' => $post['revenue_expected'] ?? null,
                'address' => $post['address'] ?? null,
            ]);
            if (!$is_updated) {
                return json_encode(['status' => false, 'message' => 'Failed to update client. Please try again.']);
            }
            return json_encode(['status' => true, 'message' => 'Client updated successfully.']);

        } else {
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
    }

    public function clients_list(Request $request){

        $clients = Clients::with('company')->where('is_delete', 0)->get();
        $data = [];
        $sr = 1;
        foreach ($clients as $client) {
            // echo "<pre>"; print_r($client->client_name); die;
            $data[] = [
                'DT_RowIndex' => $sr++,
                'client_id' => $client->client_id,
                'client_name' => $client->client_name,
                'company_name' => $client->company->company_name ?? '',
                'email' => $client->email,
                'mobile' => $client->mob,
                'action' => '-',
            ];
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // echo "<pre>";print_r($row);exit;
                $btn = '<a href="' . route('clients-add-edit', $row['client_id']) . '" class="pm-view-btn"><i class="bi bi-pencil"></i></a>';
                $btn .= ' <a href="javascript:void(0)" onclick="deleteClient(' . $row['client_id'] . ')" class="pm-delete-btn"><i class="bi bi-trash"></i></a>';
                $btn .= ' <a href="javascript:void(0)" onclick="whatsApp_messages(\'' . $row['mobile'] . '\')" class="pm-whatsapp-btn"><i class="bi bi-whatsapp"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);  
    }

    public function delete_client(Request $request)
    {
        $client_id = $request->input('client_id');
        if (empty($client_id)) {
            return json_encode(['status' => false, 'message' => 'Client ID is required.']);
        }

        $is_deleted = Clients::where('client_id', $client_id)->update(['is_delete' => 1]);
        if (!$is_deleted) {
            return json_encode(['status' => false, 'message' => 'Failed to delete client. Please try again.']);
        }

        return json_encode(['status' => true, 'message' => 'Client deleted successfully.']);
    }

}
