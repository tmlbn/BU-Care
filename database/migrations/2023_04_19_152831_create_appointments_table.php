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
            $table->unsignedBigInteger('patientID');
            $table->string('patient_type');
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->dateTime('appointmentDateTime');
            $table->string('services')->nullable();
            $table->string('others')->nullable();
            $table->text('appointmentDescription');
            $table->integer('booked_slots')->default(0);
            $table->timestamps();
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
