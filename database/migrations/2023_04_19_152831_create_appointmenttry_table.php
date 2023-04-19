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
        Schema::create('appointmenttry', function (Blueprint $table) {
            $table->id();
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->string('services')->nullable()->default(null);
            $table->string('Others')->nullable()->default(null);
            $table->text('appointmentDescription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointmenttry');
    }
};
