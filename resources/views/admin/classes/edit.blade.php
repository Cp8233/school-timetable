<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Class
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <form method="POST" action="{{ route('admin.classes.update', $class) }}" class="flex gap-3 items-center">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ old('name', $class->name) }}" 
                       class="border rounded p-2 flex-1 min-w-[200px]" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
                <a href="{{ route('admin.classes.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
            </form>
        </div>
    </div>
</x-app-layout>
