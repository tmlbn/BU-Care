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
        Schema::create('pastillness', function (Blueprint $table) {
            $table->bigIncrements('pastIllnessID')->unique();
            $table->unsignedBigInteger('MR_id')->unique();
            $table->boolean('primaryComplex');
            $table->boolean('chickenPox');
            $table->boolean('kidneyDisease');
            $table->boolean('typhoidFever');
            $table->boolean('earProblems');
            $table->boolean('heartDisease');
            $table->boolean('leukemia');
            $table->boolean('asthma');
            $table->boolean('diabetes');
            $table->boolean('eyeDisorder');
            $table->boolean('pneumonia');
            $table->boolean('dengue');
            $table->boolean('measles');
            $table->boolean('hepatitis');
            $table->boolean('rheumaticFever');
            $table->boolean('mentalDisorder');
            $table->boolean('skinProblems');
            $table->boolean('poliomyetis');
            $table->boolean('thyroidDisorder');
            $table->boolean('anemia');
            $table->boolean('mumps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastillness');
    }
};
