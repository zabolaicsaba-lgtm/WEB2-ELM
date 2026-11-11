<x-layout>
    <x-slot:title>List of persons</x-slot:title>
    <div class="w-full max-w-4xl bg-white p-6 rounded shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Registry of Persons</h1>
            <a href="{{ route('persons.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">New person</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow-sm">{{ session('success') }}</div>
        @endif
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Name</th>
                    <th class="p-3 border">Age</th>
                    <th class="p-3 border">Height (cm)</th>
                    <th class="p-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($people as $person)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 border">{{ $person->id }}</td>
                    <td class="p-3 border font-semibold">{{ $person->name }}</td>
                    <td class="p-3 border">{{ $person->age }}</td>
                    <td class="p-3 border">{{ $person->height }}</td>
                    <td class="p-3 border flex justify-center gap-2">
                        <a href="{{ route('persons.edit', $person->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">Edit</a>
                        <form action="{{ route('persons.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete it?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition cursor-pointer">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-4 text-center text-gray-500">There is no person recorded in the database yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>