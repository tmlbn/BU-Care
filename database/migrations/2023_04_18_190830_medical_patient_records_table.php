<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicalpatientrecords', function (Blueprint $table) {
            $table->bigIncrements('MPR_id')->unique();
            $table->unsignedBigInteger('student_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('personnel_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MPR_illnessID')->unique()->nullable();
            $table->date('date');
            $table->float('temperature', 8, 2);
            $table->string('bloodPressure', 7);
            $table->string('weight');
            $table->string('height');
            $table->text('historyAndPhysicalExamination');
            $table->text('physicianDirections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalpatientrecords');
    }
};
