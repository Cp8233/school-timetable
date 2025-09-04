<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Timetable
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="bg-green-100 p-2 mb-4 rounded text-green-800">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 p-2 mb-4 rounded text-red-800">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(auth()->user()->role === 'admin')
            <div class="mb-4 flex gap-4">
                <a href="{{ route('admin.timetables.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Timetable Entry
                </a>

                <form method="GET" action="{{ route('admin.timetables.index') }}" class="flex gap-2">
                    <div>
                        <label for="class_id" class="block text-sm font-medium">Filter by Class</label>
                        <select name="class_id" id="class_id" class="border p-2 rounded">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="teacher_id" class="block text-sm font-medium">Filter by Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="border p-2 rounded">
                            <option value="">All Teachers</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="flex items-end">
                    <a href="{{ request()->fullUrlWithQuery(['view' => request('view') === 'grid' ? 'list' : 'grid']) }}"
                        class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Switch to {{ request('view') === 'grid' ? 'List View' : 'Grid View' }}
                    </a>
                </div>
            </div>
        @endif
        @if(request('view') === 'grid')
            {{-- GRID VIEW --}}
            <table class="w-full border text-center mt-6">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Day \ Period</th>
                        @for($i = 1; $i <= 8; $i++)
                            <th class="p-2 border">Period {{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <tr>
                            <td class="p-2 border font-bold">{{ $day }}</td>
                            @for($i = 1; $i <= 8; $i++)
                                <td class="p-2 border">
                                    @php
                                        $entries = $timetables->where('day', $day)->where('period', $i);
                                    @endphp
                                    @forelse($entries as $entry)
                                        <div class="mb-2">
                                            <span class="block text-sm font-semibold">{{ $entry->subject->name }}</span>
                                            <span class="block text-xs text-gray-600">{{ $entry->teacher->name }}</span>
                                            <span class="block text-xs text-gray-500">({{ $entry->schoolClass->name }})</span>
                                        </div>
                                    @empty
                                        -
                                    @endforelse
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- LIST VIEW --}}
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Day</th>
                        <th class="p-2 border">Period</th>
                        <th class="p-2 border">Class</th>
                        <th class="p-2 border">Subject</th>
                        <th class="p-2 border">Teacher</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="p-2 border">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($timetables as $t)
                  
                        <tr>
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $t->day }}</td>
                            <td class="p-2 border">{{ $t->period }}</td>
                            <td class="p-2 border">{{ $t->schoolClass->name }}</td>
                            <td class="p-2 border">{{ $t->subject->name }}</td>
                            <td class="p-2 border">{{ $t->teacher->name }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td class="p-2 border flex gap-2">
                                    <a href="{{ route('admin.timetables.edit', $t) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('admin.timetables.destroy', $t) }}" method="POST"
                                        onsubmit="return confirm('Delete this entry?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-2 text-center text-gray-500">No timetable entries found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#class_id').on('change', function () {
            let classId = $(this).val();
            $.get("{{ route('admin.timetables.index') }}", { class_id: classId }, function (data) {
                renderTimetable(data);
            });
        });

        $('#teacher_id').on('change', function () {
            let teacherId = $(this).val();
            $.get("{{ route('admin.timetables.index') }}", { teacher_id: teacherId }, function (data) {
                renderTimetable(data);
            });
        });

        function renderTimetable(data) {
            let tbody = '';
            if (data.length === 0) {
                tbody = `<tr><td colspan="7" class="p-2 text-center text-gray-500">No timetable entries found</td></tr>`;
            } else {
                data.forEach((t, index) => {
                    tbody += `
                    <tr>
                        <td class="p-2 border">${index + 1}</td>
                        <td class="p-2 border">${t.day}</td>
                        <td class="p-2 border">${t.period}</td>
                        <td class="p-2 border">${t.school_class?.name ?? ''}</td>
                        <td class="p-2 border">${t.subject?.name ?? ''}</td>
                        <td class="p-2 border">${t.teacher?.user?.name ?? ''}</td>
                    </tr>
                `;
                });
            }
            $('table tbody').html(tbody);
        }
    </script>

</x-app-layout>