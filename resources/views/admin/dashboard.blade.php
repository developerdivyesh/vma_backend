<x-app-layout>
    <x-slot name="title">
        VMA Pune - Dashboard
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Welcome to Admin Panel</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Registrations Card -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total Registrations</h3>
                    <p class="text-4xl font-bold my-4">{{ $registrationCount }}</p>
                    <a href="{{ route('admin.registrations.index') }}" class="text-blue-500 hover:underline">View Registrations</a>
                </div>

                <!-- VMA Members Card -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total VMA Members</h3>
                    <p class="text-4xl font-bold my-4">{{ $vmaMemberCount }}</p>
                    <a href="{{ route('admin.vma-members.index') }}" class="text-blue-500 hover:underline">View VMA Members</a>
                </div>

                <!-- Attendance Card -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total Attendance</h3>
                    <p class="text-4xl font-bold my-4">{{ $attendanceCount }}</p>
                    <a href="{{ route('admin.attendance.list') }}" class="text-blue-500 hover:underline">View Attendance</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>