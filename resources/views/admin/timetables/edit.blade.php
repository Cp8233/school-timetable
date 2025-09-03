<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Timetable Entry
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 p-2 mb-4 rounded text-red-800">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.timetables.update', $timetable) }}" class="flex flex-col gap-3">
            @csrf
            @method('PUT')

            {{-- Day --}}
            <select name="day" class="border p-2 rounded" required>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <option value="{{ $day }}" @selected($timetable->day == $day)>{{ $day }}</option>
                @endforeach
            </select>

            {{-- Period --}}
            <input type="number" name="period" min="1" placeholder="Period"
                   class="border p-2 rounded"
                   value="{{ $timetable->period }}" required>

            {{-- Class --}}
            <select name="class_id" class="border p-2 rounded" required>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($timetable->class_id == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>

            {{-- Subject --}}
            <select id="subject_id" name="subject_id" class="border p-2 rounded" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected($timetable->subject_id == $subject->id)>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>

            {{-- Teacher (will load dynamically by subject) --}}
            <select id="teacher_id" name="teacher_id" class="border p-2 rounded" required>
                <option value="">Select Teacher</option>
            </select>

            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                Update Entry
            </button>
        </form>
    </div>

    {{-- Script for dynamic teacher loading --}}
    <script>
        function loadTeachers(subjectId, selectedTeacherId = null) {
            if (!subjectId) return;

            fetch("{{ url('/admin/teachers/by-subject') }}/" + subjectId)
                .then(response => response.json())
                .then(data => {
                    let teacherSelect = document.getElementById('teacher_id');
                    teacherSelect.innerHTML = '<option value="">Select Teacher</option>';
                    data.forEach(teacher => {
                        let selected = (teacher.id == selectedTeacherId) ? 'selected' : '';
                        teacherSelect.innerHTML += `<option value="${teacher.id}" ${selected}>${teacher.user.name}</option>`;
                    });
                });
        }

        // On subject change
        document.getElementById('subject_id').addEventListener('change', function () {
            loadTeachers(this.value);
        });

        // Load teachers initially with pre-selected teacher
        window.addEventListener('DOMContentLoaded', function () {
            let subjectId = document.getElementById('subject_id').value;
            let selectedTeacherId = "{{ $timetable->teacher_id }}";
            if (subjectId) {
                loadTeachers(subjectId, selectedTeacherId);
            }
        });
    </script>
</x-app-layout>
