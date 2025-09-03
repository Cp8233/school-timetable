<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manage Subjects
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        {{-- Add Subject --}}
        <div class="bg-white shadow rounded-lg p-6">
            @if(session('success'))
                <div class="bg-green-100 p-2 mb-4 rounded text-green-800">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.subjects.store') }}" class="flex flex-wrap gap-3 items-center">
                @csrf
                <input type="text" name="name" placeholder="Subject Name"
                    class="border rounded-md p-2 flex-1 min-w-[200px] focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                <button type="submit"
                    class="!bg-blue-600 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-blue-700 transition-colors">
                    Add
                </button>
            </form>
        </div>

        {{-- Subjects List --}}
        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">#</th>
                        <th class="p-2 border text-left">Subject Name</th>
                        <th class="p-2 border text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $subject->name }}</td>
                            <td class="p-2 border flex gap-2">
                                <a href="{{ route('admin.subjects.edit', $subject) }}"
                                    class="!bg-yellow-500 !text-white font-semibold px-3 py-1 rounded-md hover:!bg-yellow-600 transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST"
                                    onsubmit="return confirm('Delete this subject?')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="!bg-red-500 !text-white font-semibold px-3 py-1 rounded-md hover:!bg-red-600 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 text-center text-gray-500">No subjects found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>