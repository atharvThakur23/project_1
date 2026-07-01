<?php

namespace App\Http\Controllers;

use App\Models\Companies;

use Illuminate\Http\Request;

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
        return response()->json($companies);
    }

    public function save_company(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $post = $request->all();

        if(!empty($post['name']) && !empty($post['status'])){
            $is_save = Companies::create([
                    'company_name' => $post['name'],
                    'status' => $post['status'] === 'active' ? 1 : 0,
                    'created_by' => session('user_id')
                ]);

            if($is_save){
                return response()->json(['status' => 'true', 'message' => 'Company saved successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Failed to save company']); 
            }
        }
    }
}
