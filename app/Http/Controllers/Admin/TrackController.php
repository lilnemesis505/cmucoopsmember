<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrafficLog; // <--- เรียกใช้ TrafficLog แทน

class TrackController extends Controller
{
    public function store(Request $request)
    {
        TrafficLog::create([
            'page_name' => $request->page,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['success' => true]);
    }
}