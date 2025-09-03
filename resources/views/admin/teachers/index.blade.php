<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manage Teachers
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.teachers.create') }}"
            class="!bg-blue-600 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-blue-700 transition-colors">
            Add Teacher
        </a>

        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">#</th>
                        <th class="p-2 border text-left">User</th>
                        <th class="p-2 border text-left">Subject</th>
                        <th class="p-2 border text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $teacher->user->name ?? 'N/A' }} ({{ $teacher->user->email ?? '' }})
                            </td>
                            <td class="p-2 border">{{ $teacher->subject->name ?? 'N/A' }}</td>
                            <td class="p-2 border flex gap-2">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                    class="!bg-yellow-500 !text-white font-semibold px-3 py-1 rounded-md hover:!bg-yellow-600 transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                    onsubmit="return confirm('Delete this teacher?')">
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
                            <td colspan="4" class="p-2 text-center text-gray-500">No teachers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>