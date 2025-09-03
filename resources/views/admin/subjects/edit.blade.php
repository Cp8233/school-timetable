<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Subject
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            @if(session('success'))
                <div class="bg-green-100 p-2 mb-4 rounded text-green-800">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.subjects.update', $subject) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <label class="font-semibold text-gray-700">Subject Name</label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}" 
                       class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>

                <div class="flex gap-2">
                    <button type="submit" class="!bg-blue-600 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-blue-700 transition-colors">
                        Update
                    </button>
                    <a href="{{ route('admin.subjects.index') }}" class="!bg-gray-500 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-gray-600 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
