<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as ") }} <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                </div>
            </div>

            {{-- Admin Dashboard --}}
            @if(auth()->user()->role === 'admin')
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">Admin Management</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('admin.classes.index') }}"
                           class="block bg-blue-500 text-center p-6 rounded-lg shadow hover:bg-blue-600 transition">
                            <h4 class="font-semibold text-lg !text-white">Manage Classes</h4>
                            <p class="text-sm mt-2 !text-white">Add, edit or delete classes</p>
                        </a>

                        <a href="{{ route('admin.subjects.index') }}"
                           class="block bg-green-500 text-center p-6 rounded-lg shadow hover:bg-green-600 transition">
                            <h4 class="font-semibold text-lg !text-white">Manage Subjects</h4>
                            <p class="text-sm mt-2 !text-white">Organize subjects for school</p>
                        </a>

                        <a href="{{ route('admin.teachers.index') }}"
                           class="block bg-purple-500 text-center p-6 rounded-lg shadow hover:bg-purple-600 transition">
                            <h4 class="font-semibold text-lg !text-white">Manage Teachers</h4>
                            <p class="text-sm mt-2 !text-white">Add new teachers & assign subjects</p>
                        </a>

                        <a href="{{ route('admin.timetables.index') }}"
                           class="block bg-red-500 text-center p-6 rounded-lg shadow hover:bg-red-600 transition">
                            <h4 class="font-semibold text-lg !text-white">Manage Timetable</h4>
                            <p class="text-sm mt-2 !text-white">Create and manage timetable</p>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Teacher Dashboard --}}
            @if(auth()->user()->role === 'teacher')
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">Teacher Dashboard</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('timetables.index') }}"
                           class="block bg-indigo-500 text-center p-6 rounded-lg shadow hover:bg-indigo-600 transition">
                            <h4 class="font-semibold text-lg !text-white">My Timetable</h4>
                            <p class="text-sm mt-2 !text-white">View your assigned timetable</p>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
