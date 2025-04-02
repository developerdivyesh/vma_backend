<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Otp;

class RegistrationController extends Controller
{
    public function index()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    
        $registrations = Registration::latest()->get();
        return view('admin.registrations.index', compact('registrations'));
    }


    public function showForm()
    {
        return view('event_registration.registration');
    }

    // Handle registration form submission
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:registrations,mobile',
            'source' => 'nullable|string|max:255',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event_registration.form')
                ->withErrors($validator)
                ->withInput();
        }

        $otpRecord = Otp::where('mobile', $request->mobile)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', now())
        ->first();

        if (!$otpRecord) {
            return redirect()->route('event_registration.form')
                ->withErrors(['otp' => 'Invalid or expired OTP.'])
                ->withInput();
        }

        // Create new registration entry
        $registration = Registration::create([
            'name'   => $request->name,
            'mobile' => $request->mobile,
            'source' => $request->source,
        ]);

        // Get registration ID
        $registrationId = $registration->id;

        // Ensure the QR codes directory exists
        $qrCodePath = public_path('qrcodes');
        if (!file_exists($qrCodePath)) {
            mkdir($qrCodePath, 0777, true);
        }

        // Generate QR Code
        $randomString = Str::random(8);
        $qrFileName = $request->mobile . '_' . $randomString . '.png';
        $qrFilePath = $qrCodePath . '/' . $qrFileName;

        QrCode::format('png')->size(300)->generate($registrationId, $qrFilePath);

        // Save QR Code Path
        $registration->update(['qr_code_path' => $qrFileName]);

        return redirect()->route('event_registration.success', $registration->id);
    }

    // Show success page with QR Code
    public function success($id)
    {
        $registration = Registration::findOrFail($id);
        return view('event_registration.success', compact('registration'));
    }


    public function showQr($id)
    {
        $registration = Registration::findOrFail($id);
        return view('event_registration.show_qr', compact('registration'));
    }
}
