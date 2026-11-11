<x-layout>
    <x-slot:title>Add new person</x-slot:title>
    <div class="w-full max-w-md bg-white p-6 rounded shadow-md">
        <h1 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Add new person</h1>
        <form action="{{ route('persons.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" name="name" required class="mt-1 w-full p-2 border rounded focus:outline-blue-500" value="{{ old('name') }}">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kor:</label>
                <input type="number" name="age" class="mt-1 w-full p-2 border rounded focus:outline-blue-500" value="{{ old('age') }}">
                @error('age') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Height (cm):</label>
                <input type="number" step="0.1" name="height" required class="mt-1 w-full p-2 border rounded focus:outline-blue-500" value="{{ old('height') }}">
                @error('height') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-between items-center pt-2">
                <a href="{{ route('persons.index') }}" class="text-gray-600 hover:underline">Back</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition cursor-pointer">Save</button>
            </div>
        </form>
    </div>
</x-layout>