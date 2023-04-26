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
        Schema::create('immunizationhistory', function (Blueprint $table) {
            $table->bigIncrements('immunizationHistoryID')->unique();
            $table->unsignedBigInteger('MR_id')->unique()->nullable()->default(null);
            $table->boolean('BCG');
            $table->boolean('chickenPox');
            $table->boolean('polio');
            $table->boolean('DPT');
            $table->boolean('mumps');
            $table->boolean('measles');
            $table->boolean('typhoid');
            $table->boolean('germanMeasles');
            $table->boolean('hepatitisA');
            $table->boolean('hepatitisB');
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
        Schema::dropIfExists('immunizationhistory');
    }
};
