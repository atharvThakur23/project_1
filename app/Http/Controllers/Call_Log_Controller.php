<?php

namespace App\Http\Controllers;
use App\Models\Clients;
use App\Models\Call_Log;
use App\Models\Tags;

use Illuminate\Http\Request;

class Call_Log_Controller extends Controller
{
    public function call_log()
    {
        $clients = Clients::where('is_delete', 0)->get();
        return view('call_log', compact('clients'));
    }

    public function client_search(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); die;
        $searchTerm = $request->input('search');

        $clients = Clients::where(function ($query) use ($searchTerm) {
            $query->where('client_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('mob', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                ->where('is_delete', 0)
                ->get();
        $result = [];
        foreach ($clients as $client) {
            $result[] = [
                'id'   => $client->client_id,
                'text' => $client->client_name."-".$client->mob."-".$client->email,
            ];
        }
        return response()->json($result);
    }

    public function get_tags(Request $request)
    {
        $status = $request->input('status');
        $tags = Tags::where('status', $status)
                ->where('is_delete', 0)
                ->get();
        return response()->json($tags);
    }

    public function save_call_log(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); die;
        $validatedData = $request->validate([
            'client' => 'required|exists:clients,client_id',
            'call_tag' => 'required|exists:tags,tag_id',
            'status' => 'required',
            'remark' => 'nullable|string',
        ]);

        $post = $request->all();
        if(!empty($post)){
            // echo "<pre>"; print_r($post); die;
            $call_log = new Call_Log();
            $call_log->client_id = $post['client'];
            $call_log->tag_id = $post['call_tag'];
            $call_log->status = $post['status'];
            if(!empty($post['follow_up_date'])){
                if($post['call_tag'] == 7) {
                    $call_log->is_follow_up = 0;
                    $call_log->follow_up_date = $post['follow_up_date'];
                } else {
                    $call_log->is_follow_up = null;
                    $call_log->follow_up_date = null;
                }
            }
            
            $call_log->remark = isset($post['remark']) ? $post['remark'] : null;
            $call_log->created_by = auth()->user()->id; // Assuming you have authentication set up
            $call_log->save();

            return response()->json(['status' => true, 'message' => 'Call log saved successfully.']);
        }

        return response()->json(['status' => false, 'message' => 'Failed to save call log.']);
    }
}
