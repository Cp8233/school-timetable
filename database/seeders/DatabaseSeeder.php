<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        $teacherUser = User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher',
        ]);

        $class6A = SchoolClass::create(['name' => 'Class 6A']);
        $class10B = SchoolClass::create(['name' => 'Class 10B']);

        $maths = Subject::create(['name' => 'Maths']);
        $science = Subject::create(['name' => 'Science']);
        $english = Subject::create(['name' => 'English']);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'subject_id' => $maths->id,
        ]);

        Timetable::create([
            'day' => 'Monday',
            'period' => 1,
            'class_id' => $class6A->id,
            'subject_id' => $maths->id,
            'teacher_id' => $teacher->id,
        ]);

        Timetable::create([
            'day' => 'Tuesday',
            'period' => 2,
            'class_id' => $class6A->id,
            'subject_id' => $science->id,
            'teacher_id' => $teacher->id,
        ]);
    }
}
