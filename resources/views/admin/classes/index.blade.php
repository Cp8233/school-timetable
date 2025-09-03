<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manage Classes
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        {{-- Add Class --}}
        <div class="bg-white shadow rounded-lg p-6">
            @if(session('success'))
                <div class="bg-green-100 p-2 mb-4 rounded text-green-800">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.classes.store') }}" class="flex flex-wrap gap-3 items-center">
                @csrf
                <input type="text" name="name" placeholder="Class Name" 
                       class="border rounded-md p-2 flex-1 min-w-[200px] focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition-colors">Add</button>
            </form>
        </div>

        {{-- Classes List --}}
        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">#</th>
                        <th class="p-2 border text-left">Class Name</th>
                        <th class="p-2 border text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $class->name }}</td>
                            <td class="p-2 border flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('admin.classes.edit', $class) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-3 py-1 rounded-md transition-colors">Edit</a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Delete this class?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-1 rounded-md transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 text-center text-gray-500">No classes found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
