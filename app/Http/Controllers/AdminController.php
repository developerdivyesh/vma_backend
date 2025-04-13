<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch counts
        $registrationCount = Registration::count();
        $vmaMemberCount = User::where('is_vma', true)->count();
        $attendanceCount = Attendance::count();

        // Pass counts to the view
        return view('admin.dashboard', compact('registrationCount', 'vmaMemberCount', 'attendanceCount'));
    }
}
