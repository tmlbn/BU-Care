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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique()->default(0);
            $table->unsignedBigInteger('student_id')->nullable()->default(null);
            $table->unsignedBigInteger('personnel_id')->nullable()->default(null);
            $table->string('patient_type');
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->dateTime('appointmentDateTime');
            $table->string('services')->nullable();
            $table->string('others')->nullable();
            $table->text('appointmentDescription');
            $table->integer('booked_slots')->default(0);
            $table->string('status')->default('ACTIVE');
            $table->boolean('released')->default(0);
            $table->timestamps();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('users_students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('personnel_id')
                ->references('id')
                ->on('users_personnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('medicalrecords_admin', function (Blueprint $table){
            $table->foreign('ticketID')
                ->references('ticket_id')
                ->on('appointments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
