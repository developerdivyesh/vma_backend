<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller {


    public function scanQR(Request $request) {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $registration_id = $request->registration_id;
        $user_id = $request->user_id;

        // Check if already scanned
        if (Attendance::where('registration_id', $registration_id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'QR code already scanned'
            ], 422);
        }

        // Store attendance record
        $attendance = Attendance::create([
            'registration_id' => $registration_id,
            'user_id' => $user_id,
            'scanned_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'QR code scanned successfully', 
            'data' => $attendance
        ], 201);
    }


    public function scannedList(Request $request) {
        $user_id = Auth::id(); 
    
        $scannedList = Attendance::where('user_id', $user_id)
            ->with('registration:id,name,mobile')
            ->orderBy('scanned_at', 'desc')
            ->get();
    
        return response()->json([
            'message' => 'Scanned QR codes retrieved successfully',
            'data' => $scannedList
        ]);
    }
}
