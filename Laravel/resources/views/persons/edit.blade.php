<x-layout>
    <x-slot:title>Edit person</x-slot:title>
    <div class="w-full max-w-md bg-white p-6 rounded shadow-md">
        <h1 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Edit person</h1>
        <form action="{{ route('persons.update', $person->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" name="name" value="{{ old('name', $person->name) }}" required class="mt-1 w-full p-2 border rounded focus:outline-yellow-500">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Age:</label>
                <input type="number" name="age" value="{{ old('age', $person->age) }}" required class="mt-1 w-full p-2 border rounded focus:outline-yellow-500">
                @error('age') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Height (cm):</label>
                <input type="number" step="0.1" name="height" value="{{ old('height', $person->height) }}" required class="mt-1 w-full p-2 border rounded focus:outline-yellow-500">
                @error('height') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-between items-center pt-2">
                <a href="{{ route('persons.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition cursor-pointer">Update</button>
            </div>
        </form>
    </div>
</x-layout>