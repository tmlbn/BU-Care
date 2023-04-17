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
            $table->bigIncrements('id');
            $table->string('applicant_id_number', 11)->unique();
            $table->string('student_id_number', 20)->nullable();
            $table->string('email', 70)->nullable();
            $table->string('password', 60)->nullable();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('birth_month', 9);
            $table->integer('birth_date');
            $table->integer('birth_year');
            $table->timestamps();
            $table->bigInteger('MR_id')->unsigned()->nullable();
            $table->bigInteger('MRA_id')->unsigned()->nullable();
            $table->tinyInteger('hasMedRecord')->default(0);
            $table->tinyInteger('hasValidatedRecord')->default(0);
            $table->string('user_type', 10)->default('PATIENT');
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
