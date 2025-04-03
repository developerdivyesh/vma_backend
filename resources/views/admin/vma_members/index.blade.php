<x-app-layout>
    <x-slot name="title">
        VMA Pune - VMA Members
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('VMA Members') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.vma-members.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Member
                        </a>
                    </div>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Mobile</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->email }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->mobile }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($member->status) }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('admin.vma-members.edit', $member) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>