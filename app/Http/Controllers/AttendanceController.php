<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Registration;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct() {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    }

    public function index(Request $request) {
        $search = $request->input('search');
    
        // Fetch attendance records with related user and registration details
        $attendances = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->join('registrations', 'attendances.registration_id', '=', 'registrations.id')
            ->when($search, function ($query, $search) {
                $query->where('users.name', 'like', "%$search%")
                      ->orWhere('registrations.name', 'like', "%$search%")
                      ->orWhere('registrations.mobile', 'like', "%$search%");
            })
            ->select(
                'attendances.registration_id',
                'users.name as user_name',
                'registrations.name as visitor_name',
                'registrations.mobile as visitor_mobile',
                'attendances.scanned_at'
            )
            ->orderBy('attendances.scanned_at', 'desc')
            ->paginate(10); // Paginate with 10 records per page
    
        return view('admin.registrations.attendance', compact('attendances', 'search'));
    }
}

?>