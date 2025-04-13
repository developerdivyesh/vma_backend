<x-app-layout>
    <x-slot name="title">
        VMA Pune - Registrations
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center">
                        <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex items-center mb-4 sm:mb-0">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search by name or mobile" 
                                class="border border-gray-300 rounded px-4 py-2 mr-2"
                            >
                            <button 
                                type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Search
                            </button>
                            &nbsp;
                            <a 
                                href="{{ route('admin.registrations.index') }}" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Refresh
                            </a>
                        </form>
                        <a href="{{ route('registrations.export') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Download Excel
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">ID</th>
                                    <th class="border border-gray-300 px-4 py-2">Name</th>
                                    <th class="border border-gray-300 px-4 py-2">Mobile</th>
                                    <th class="border border-gray-300 px-4 py-2">Age</th>
                                    <th class="border border-gray-300 px-4 py-2">Native</th>
                                    <th class="border border-gray-300 px-4 py-2">Source</th>
                                    <th class="border border-gray-300 px-4 py-2">QR Code</th>
                                    <th class="border border-gray-300 px-4 py-2">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->salutation }} {{ $registration->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->mobile }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->age }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->native_place }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $registration->source }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($registration->qr_code_path)
                                                <img src="{{ asset('qrcodes/' . $registration->qr_code_path) }}" alt="QR Code" class="w-16 h-16">
                                                <a href="{{ route('show_qr', ['id' => $registration->id]) }}" target="_blank">QR Link</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>