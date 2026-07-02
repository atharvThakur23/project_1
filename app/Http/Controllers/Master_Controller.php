<?php

namespace App\Http\Controllers;

use App\Models\Companies;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Master_Controller extends Controller
{
    public function company_master()
    {
        return view('masters.company_master_list');
    }

    public function list_companies()
    {
        $companies = Companies::select('company_id', 'company_name', 'status')
            ->where('is_delete', 0)
            ->get()
            ->map(function ($company) {
                return [
                    'company_id' => $company->company_id,
                    'company_name' => $company->company_name,
                    'status' => $company->status == 1 ? 'Active' : 'Inactive',
                ];
            })
            ->toArray();
        // echo "<pre>";print_r($companies);exit;
        return DataTables::of($companies)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            return '
                <button class="btn btn-primary btn-sm" onclick="editCompany(' . $row['company_id'] . ')">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteCompany(' . $row['company_id'] . ')">Delete</button>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
        // return response()->json($companies);
    }

    public function save_company(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $post = $request->all();

        if(!empty($post['name']) && !empty($post['status'])){
            $is_save = Companies::create([
                    'company_name' => $post['name'],
                    'status' => $post['status'],
                    'created_by' => session('user_id')
                ]);

            if($is_save){
                return response()->json(['status' => 'true', 'message' => 'Company saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save company']); 
            }
        }
    }

    public function get_company_data(Request $request)
    {
        $company_id = $request->company_id;
        if(empty($company_id)){
            return response()->json(['status' => 'false', 'data' => 'Company ID is required']);
        }

        $company = Companies::find($company_id);

        if ($company) {
            return response()->json(['status' => 'true', 'data' => $company]);
        } else {
            return response()->json(['status' => 'false', 'data' => 'Company not found']);
        }
    }

    public function update_company(Request $request)
    {
        // Validate the request data
        $request->validate([
            'company_id' => 'required|exists:companies,company_id',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $post = $request->all();

        if(!empty($post['company_id']) && !empty($post['name']) && $post['status'] != ''){
            $company = Companies::where('company_id', $post['company_id'])->where('is_delete', 0)->first();
            if ($company) {
                $company->company_name = $post['name'];
                $company->status = $post['status'];
                $is_update = $company->save();

                if($is_update){
                    return response()->json(['status' => 'true', 'message' => 'Company updated successfully']);
                }else{
                    return response()->json(['status' => 'false', 'message' => 'Failed to update company']); 
                }
            } else {
                return response()->json(['status' => 'false', 'message' => 'Company not found']);
            }
        }
    }

    public function delete_company(Request $request)
    {
        $company_id = $request->company_id;
        if(empty($company_id)){
            return response()->json(['status' => 'false', 'message' => 'Company ID is required']);
        }

        $company = Companies::where('company_id', $company_id)->where('is_delete', 0)->first();
        if($company){
            $company->is_delete = 1;
            $is_delete = $company->save();

            if($is_delete){
                return response()->json(['status' => 'true', 'message' => 'Company deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to delete company']); 
            }

        }

    }
}
