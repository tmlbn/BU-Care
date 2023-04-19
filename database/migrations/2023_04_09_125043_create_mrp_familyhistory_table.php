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
        Schema::create('mrp_familyhistory', function (Blueprint $table) {
            $table->bigIncrements('MRP_familyHistoryID')->unique();
            $table->unsignedBigInteger('MRP_id')->unique();
            $table->boolean('cancer');
            $table->boolean('heartDisease');
            $table->boolean('hypertension');
            $table->boolean('thyroidDisease');
            $table->boolean('tuberculosis');
            $table->boolean('hivAids');
            $table->boolean('diabetesMelittus');
            $table->boolean('mentalDisorder');
            $table->boolean('asthma');
            $table->boolean('convulsions');
            $table->boolean('bleedingDyscrasia');
            $table->boolean('eyeDisorder');
            $table->boolean('skinProblems');
            $table->boolean('kidneyProblems');
            $table->boolean('gastrointestinalDisease');
            $table->boolean('hepatitis');
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
        Schema::dropIfExists('mrp_familyhistory');
    }
};
