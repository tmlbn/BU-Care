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
        Schema::create('users_students', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('applicant_id_number', 20)->unique();
            $table->string('student_id_number', 20)->unique()->nullable()->default(null);
            $table->string('email', 50)->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable()->default(null);
            $table->string('birth_month', 9);
            $table->unsignedTinyInteger('birth_date');
            $table->unsignedSmallInteger('birth_year');
            $table->unsignedBigInteger('MR_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MRA_id')->unique()->nullable()->default(null);
            $table->boolean('hasMedRecord')->nullable()->default(false);
            $table->boolean('hasValidatedRecord')->nullable()->default(false);
            $table->string('user_type', 15)->default('PATIENT/STUDENT');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_students');
    }
};
