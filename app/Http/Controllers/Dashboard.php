<?php

namespace App\Http\Controllers;

use App\Models\{Clients,Call_log};
use Illuminate\Http\Request;
use Carbon\carbon;

class Dashboard extends Controller
{
    public function index()
    {
        $expected_revenue = Clients::where('is_delete',0)
                            ->sum('expected_revenue');    
        
        $clients = Clients::where('is_delete', 0)->get();
        $clientCout = count($clients);

        $followUpCalls = Call_Log::where('tag_id', 7)
                        ->where('is_follow_up', 0)
                        ->whereDate('follow_up_date', Carbon::today())
                        ->get();
        $followUpCount = count($followUpCalls);

        $birthDays = Clients::where('is_delete', 0)
                    ->whereMonth('dob', Carbon::now()->month)
                    ->whereDay('dob', Carbon::now()->day)
                    ->get();

        return view('dashboard',compact('expected_revenue','clientCout','clients','followUpCount','birthDays'));
    }
}
