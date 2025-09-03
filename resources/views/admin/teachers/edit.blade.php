<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Teacher
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <label class="font-semibold text-gray-700">User</label>
                <select name="user_id" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $teacher->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>

                <label class="font-semibold text-gray-700">Subject</label>
                <select name="subject_id" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $teacher->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="!bg-blue-600 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-blue-700 transition-colors">
                        Update
                    </button>
                    <a href="{{ route('admin.teachers.index') }}" class="!bg-gray-500 !text-white font-semibold px-4 py-2 rounded-md hover:!bg-gray-600 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
