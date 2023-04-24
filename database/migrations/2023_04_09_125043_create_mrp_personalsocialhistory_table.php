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
        Schema::create('mrp_personalsocialhistory', function (Blueprint $table) {
            $table->bigIncrements('MRP_personalSocialHistoryID')->unique();
            $table->boolean('smoking');
            $table->string('sticksPerDay', 100);
            $table->string('years', 100);
            $table->boolean('eCig');
            $table->boolean('vape');
            $table->boolean('drinking');
            $table->string('drinkingDetails', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrp_personalsocialhistory');
    }
};
