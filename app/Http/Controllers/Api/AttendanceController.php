<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller {

    private int $userId;

    public function __construct() {
        $this->userId = Auth::id();
    }

    public function scanQR(Request $request) {
        try {
            $request->validate([
                'registration_id' => 'required|exists:registrations,id'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid QR code or QR not exist in our records',
                'statusCode'=> 422    
            ], 200);
        }

        $registration_id = $request->registration_id;

        // Check if already scanned
        if (Attendance::where('registration_id', $registration_id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'QR code already scanned',
                'statusCode'=> 409
            ], 200);
        }

        // Store attendance record
        $attendance = Attendance::create([
            'registration_id' => $registration_id,
            'user_id' => $this->userId,
            'scanned_at' => now()
        ]);

        // Fetch user details related to the registration
        $registration = Registration::find($registration_id);

        return response()->json([
            'status' => true,
            'message' => 'QR code scanned successfully',
            'welcomeMessage' => "Welcome $registration->name Ji to the event!",
            'data' => [
                'attendance' => $attendance,
                'user' => $registration
            ]
        ], 201);
    }


    public function scannedList(Request $request) {    
        $scannedList = Attendance::where('user_id', $this->userId)
            ->with('registration:id,name,mobile')
            ->orderBy('scanned_at', 'desc')
            ->get();

        if ($scannedList->isEmpty()) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'No scanned QR codes found',
                'data' => []
            ], 200);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Scanned QR codes retrieved successfully',
            'data' => $scannedList
        ]);
    }
}
