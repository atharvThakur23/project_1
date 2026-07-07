<?php

namespace App\Http\Controllers;
use App\Models\Clients;
use App\Models\Call_Log;
use App\Models\Tags;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Call_Log_Controller extends Controller
{
    public function call_log()
    {
        $clients = Clients::where('is_delete', 0)->get();
        $clientCout = count($clients);

        $followUpCalls = Call_Log::where('tag_id', 7)
                        ->where('is_follow_up', 0)
                        ->whereDate('follow_up_date', Carbon::today())
                        ->get();
        $followUpCount = count($followUpCalls);

        $dueFollowUpCalls = Call_Log::where('tag_id', 7)
                        ->where('is_follow_up', 0)
                        ->whereDate('follow_up_date', '<', Carbon::today())
                        ->get();
        $dueFollowUpCount = count($dueFollowUpCalls);


        // echo "<pre>";print_r(count($followUpCalls));die;
        
        return view('call_log', compact('clients','clientCout','followUpCount','dueFollowUpCount'));
    }

    public function view_call_log(Request $request)
    {
        $latestCalls = Call_Log::query()
        ->select('client_id', DB::raw('MAX(call_id) as last_call_id'))
        ->where('is_delete', 0)
        ->groupBy('client_id');

        $call_logs = Call_Log::with(['client', 'tag'])
            ->joinSub($latestCalls, 'latest', function ($join) {
                $join->on('call_logs.call_id', '=', 'latest.last_call_id');
            })
            ->select('call_logs.*')
            ->orderBy('call_logs.call_datetime', 'desc')
            ->where('call_logs.is_delete', 0)
            ->get();
            // echo "<pre>"; print_r($call_logs->get()); die;
            $data = [];
            $i = 1;
            foreach ($call_logs as $log) {
                // echo "<pre>"; print_r($log); die;
                $data[] = [
                    'DT_RowIndex' => $i++,
                    'call_id' => $log->call_id,
                    'client_name' => $log->client->client_name ?? '',
                    'client_id' => $log->client_id,
                    'company_name' => $log->client->company->company_name ?? '',
                    'mob' => $log->client->mob ?? '',
                    'email' => $log->client->email ?? '',
                    'tag_name' => $log->tag->tag_name ?? '',
                    'tagid' => $log->tag_id,
                    'status' => ($log->status == 1) ? 'Connected' : 'Not Connected',
                    'remark' => $log->remark,
                    'follow_up_date' => $log->follow_up_date,
                    'created_at' => $log->created_at,
                ];
            }
        // echo "<pre>"; print_r($data); die;

        return DataTables::of($data)
        ->addColumn('client_details', function ($row) {
            $clientDetails = $row['client_name'] . '<br>' . $row['company_name'];
            return $clientDetails;
        })
        ->addColumn('mob_email', function ($row) {
            $mobEmail = $row['mob'] . '<br>' . $row['email'];
            return $mobEmail;
        })
        ->addColumn('last_tag', function ($row) {
            // echo "<pre>"; print_r($row); die;
            $followUpDate = $row['follow_up_date'] ? date('d-m-Y', strtotime($row['follow_up_date'])) : '';
            if(in_array($row['tagid'], [6,7])) {
                $class = 'btn-follow-up';
            } else if(in_array($row['tagid'], [2,9])) {
                $class = 'btn-not-interested';
            }else if(in_array($row['tagid'], [1,8,10])) {
                $class = 'btn-busy'; 
            
            }else {
                $class = '';
            }
            $lastTag = "<span class='btn " . $class . "'>" . $row['tag_name'] . "</span><br>" . $followUpDate;
            return $lastTag;
        })
        ->addColumn('action', function ($row) {
            $actionBtn = '<a href="javascript:void(0)" onclick="view_call_log(\'' . $row['client_id'] . '\')" class="pm-view-btn"><i class="bi bi-eye"></i></a>';
            $actionBtn .= '&nbsp;<a href="javascript:void(0)" onclick="whatsApp_messages(\'' . $row['mob'] . '\')" class="pm-whatsapp-btn"><i class="bi bi-whatsapp"></i></a>';
            $actionBtn .= '&nbsp;<a href="javascript:void(0)" onclick="tagCall(\'' . $row['client_id'] . '\')" class="pm-view-btn"><i class="bi bi-telephone-plus"></i></a>';
            return $actionBtn;
        })
        ->rawColumns(['client_details','mob_email','last_tag','action'])
        ->make(true);

        return response()->json($call_logs);
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

            // Check last tag of client
            $getClientLastTag = Call_log::where('client_id',$post['client'])
                                        ->orderByDesc('call_id')
                                        ->first();
            if(!empty($getClientLastTag)){
                if($getClientLastTag->tag_id == 7 && $getClientLastTag->is_follow_up == 0){
                    Call_log::where('call_id',$getClientLastTag->call_id)
                            ->update(['is_follow_up'=>1]);
                }
            }

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

    public function call_history(Request $request)
    {
        $client_id = $request->input('client_id');
        if(empty($client_id)){
            return response()->json(['status' => false, 'message' => 'Client ID is required.']);
        }
        $call_logs = Call_Log::with(['tag'])
            ->where('client_id', $client_id)
            ->where('is_delete', 0)
            ->orderBy('call_datetime', 'desc')
            ->get();
        $logs = [];
        foreach ($call_logs as $log) {
            $logs[] = [
                'call_id' => $log->call_id,
                'tag_id' => $log->tag_id,
                'tag_name' => $log->tag->tag_name ?? '',
                'status' => ($log->status == 1) ? 'Connected' : 'Not Connected',
                'remark' => $log->remark,
                'follow_up_date' => $log->follow_up_date,
                'created_at' => $log->created_at,
                'follow_up_status' => ($log->is_follow_up == 0 && $log->tag_id == 7) ? 'Pending' : 'Completed',
                'follow_up_date' => $log->follow_up_date ? date('d-M-Y', strtotime($log->follow_up_date)) : '',
                'call_datetime' => $log->call_datetime ? date('d-M-Y h:i A', strtotime($log->call_datetime)) : '',
            ];
        }

        // echo "<pre>"; print_r($logs); die;
        return json_encode($logs);
    }
}
