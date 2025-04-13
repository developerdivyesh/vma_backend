<x-app-layout>
    <x-slot name="title">
        VMA Pune - Attendance List
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.attendance.list') }}" class="mb-4">
                        <div class="flex">
                            <input type="text" name="search" class="form-input w-full border border-gray-300 rounded-l-md px-4 py-2" placeholder="Search by name or mobile" value="{{ $search }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-md">
                                Search
                            </button>
                            <a href="{{ route('admin.attendance.list') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Refresh
                            </a>
                        </div>
                    </form>

                    <!-- Attendance Table -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Reg. ID</th>
                                <th class="border border-gray-300 px-4 py-2">Visitor Name</th>
                                <th class="border border-gray-300 px-4 py-2">Visitor Mobile</th>
                                <th class="border border-gray-300 px-4 py-2">User Name</th>
                                <th class="border border-gray-300 px-4 py-2">Scanned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attendance->registration_id }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attendance->visitor_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attendance->visitor_mobile }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $attendance->user_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($attendance->scanned_at)->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>