<?php

namespace App\Http\Controllers;

use App\Models\{Clients,Companies};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
            $client = (object) [];
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

    public function upload_client(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'upload' => 'required|file|mimes:xlsx,xls',
        ]);

        // Handle the uploaded file
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $data = Excel::toArray([], $file);
            // echo "<pre>"; print_r($data); die;
            for($i=1; $i<count($data[0]); $i++){
                $row = $data[0][$i];
                $dob = Date::excelToDateTimeObject(strtotime($row[3]))->format('Y-m-d');
                echo "<pre>"; print_r($dob); die;
                if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3])){
                    Clients::create([
                        'client_name' => trim($row[0]),
                        'company_id' => trim($row[1]),
                        'email' => trim($row[2]),
                        'mob' => trim($row[3]),
                        'dob' => $row[4] ?? null,
                        'expected_revenue' => $row[5] ?? null,
                        'address' => $row[6] ?? null,
                        'register_by' => session('user_id'), 
                    ]);
                }
            }
            $filePath = $file->store('uploads', 'public');

            // Process the uploaded file (e.g., read data, save to database, etc.)
            // You can use a library like PhpSpreadsheet to read Excel files

            return json_encode(['status' => true, 'message' => 'File uploaded successfully.', 'file_path' => $filePath]);
        } else {
            return json_encode(['status' => false, 'message' => 'No file uploaded.']);
        }
    }

}
