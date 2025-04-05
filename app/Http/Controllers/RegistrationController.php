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
    
        $registrations = Registration::latest()->paginate(50);
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
            'salutation' => 'required|string|in:Mr.,Ms.,Mrs.',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'source' => 'nullable|string|max:20',
            'age' => 'required|integer|min:1|max:120',
            'otp' => 'required|digits:6',
            'native_place' => 'required|string|max:255',
        ], [
            'mobile.unique' => 'You have already registered.',
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
            'salutation' => $request->salutation,
            'name'     => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile'     => $request->mobile,
            'source'     => $request->source,
            'age'        => $request->age,
            'native_place' => $request->native_place,
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
