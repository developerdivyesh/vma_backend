<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Otp;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        Otp::updateOrCreate(
            ['mobile' => $request->mobile],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        $url = "http://dg.smsjockey.com/V2/http-api.php?apikey=ou9kbtfMqxiBSsKv&senderid=JOPlnt&number=$request->mobile&message=Hello,%20$otp%20is%20an%20OTP%20to%20confirm%20your%20registration.%20NEVER%20SHARE%20IT%20WITH%20ANYONE.%20JOPInt&format=json";

        try {
            $response = @file_get_contents($url);

            \Log::info('SMS API Response:', [
                'status' => $response,
                'mobile' => $request->mobile,
                'otp' => $otp,
            ]);
    
            if ($response === FALSE) {
                throw new \Exception('Failed to send the request.');
            }
    
            $data = json_decode($response, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from the API.');
            }
    
            // Check the API response status
            if ($data['status'] === 'OK' && isset($data['data'][0]['status']) && $data['data'][0]['status'] === 'SUBMITTED') {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully!',
                    'otp' => $otp // You may choose to send the OTP back, depending on your security policy
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Failed to send OTP.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $otpRecord = Otp::where('mobile', $request->mobile)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.']);
        }

        return response()->json(['success' => true, 'message' => 'OTP verified successfully.']);
    }
}