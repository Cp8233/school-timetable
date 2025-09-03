<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->integer('period');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->unique(['day', 'period', 'class_id']);
            $table->unique(['day', 'period', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
