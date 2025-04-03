<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VmaMemberController extends Controller
{
    public function index()
    {
        $members = User::where('is_vma', true)->get();
        return view('admin.vma_members.index', compact('members'));
    }


    public function create()
    {
        return view('admin.vma_members.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:10|unique:users,mobile',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'is_vma' => true,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vma-members.index')->with('success', 'VMA Member added successfully.');
    }


    public function edit(User $user)
    {
        return view('admin.vma_members.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:10|unique:users,mobile,' . $user->id,
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vma-members.index')->with('success', 'VMA Member updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.vma-members.index')->with('success', 'VMA Member deleted successfully.');
    }
}