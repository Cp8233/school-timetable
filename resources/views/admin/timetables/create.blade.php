<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Timetable Entry
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

        <form method="POST" action="{{ route('admin.timetables.store') }}" class="flex flex-col gap-3">
            @csrf
            <select name="day" class="border p-2 rounded" required>
                <option value="">Select Day</option>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>

            <input type="number" name="period" min="1" placeholder="Period" class="border p-2 rounded" required>

            <select name="class_id" class="border p-2 rounded" required>
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

            <select id="subject_id" name="subject_id" class="border p-2 rounded" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>

            <select id="teacher_id" name="teacher_id" class="border p-2 rounded" required>
                <option value="">Select Teacher</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add Entry
            </button>
        </form>
    </div>
    <script>
        document.getElementById('subject_id').addEventListener('change', function () {
            let subjectId = this.value;

            if (!subjectId) {
                document.getElementById('teacher_id').innerHTML = '<option value="">Select Teacher</option>';
                return;
            }

            fetch(`/admin/teachers/by-subject/${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    let teacherSelect = document.getElementById('teacher_id');
                    teacherSelect.innerHTML = '<option value="">Select Teacher</option>';
                    data.forEach(teacher => {
                        teacherSelect.innerHTML += `<option value="${teacher.user.id}">${teacher.user.name}</option>`;
                    });
                });
        });
    </script>
</x-app-layout>