<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            My Timetable ({{ $teacher->user->name }})
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Day</th>
                    <th class="border p-2">Period</th>
                    <th class="border p-2">Class</th>
                    <th class="border p-2">Subject</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timetable as $day => $entries)
                    @foreach($entries as $entry)
                        <tr>
                            <td class="border p-2">{{ $day }}</td>
                            <td class="border p-2">{{ $entry->period }}</td>
                            <td class="border p-2">{{ $entry->class->name }}</td>
                            <td class="border p-2">{{ $entry->subject->name }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
