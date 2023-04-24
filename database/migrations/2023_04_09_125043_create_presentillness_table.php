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
        Schema::create('presentillness', function (Blueprint $table) {
            $table->bigIncrements('presentIllnessID')->unique();
            $table->boolean('chestPain');
            $table->boolean('insomnia');
            $table->boolean('jointPains');
            $table->boolean('dizziness');
            $table->boolean('headaches');
            $table->boolean('indigestion');
            $table->boolean('swollenFeet');
            $table->boolean('weightLoss');
            $table->boolean('nauseaOrVomiting');
            $table->boolean('soreThroat');
            $table->boolean('frequentUrination');
            $table->boolean('difficultyOfBreathing');
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
        Schema::dropIfExists('presentillness');
    }
};
