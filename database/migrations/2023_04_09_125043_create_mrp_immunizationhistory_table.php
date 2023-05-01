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
        Schema::create('mrp_immunizationhistory', function (Blueprint $table) {
            $table->bigIncrements('MRP_immunizationHistoryID')->unique();
            $table->unsignedBigInteger('MRP_id')->unique()->nullable()->default(null);
            $table->boolean('bcg');
            $table->boolean('polio');
            $table->boolean('chickenPox');
            $table->boolean('dpt');
            $table->boolean('covidVacc');
            $table->string('covidVaccName', 50);
            $table->string('covidBoosterName', 50);
            $table->boolean('typhoid');
            $table->boolean('mumps');
            $table->boolean('hepatitisA');
            $table->boolean('hepatitisB');
            $table->boolean('measles');
            $table->boolean('germanMeasles');
            $table->boolean('pneumococcal');
            $table->boolean('influenza');
            $table->boolean('hpv');
            $table->boolean('others');
            $table->string('othersDetails', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrp_immunizationhistory');
    }
};
