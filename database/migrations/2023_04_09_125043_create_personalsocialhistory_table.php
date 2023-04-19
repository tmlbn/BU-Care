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
        Schema::create('personalsocialhistory', function (Blueprint $table) {
            $table->bigIncrements('personalSocialHistoryID')->unique();
            $table->unsignedBigInteger('MR_id')->unique();
            $table->boolean('smoking');
            $table->string('sticksPerDay', 100);
            $table->string('years', 100);
            $table->boolean('drinking');
            $table->string('numberOfBeers', 100);
            $table->string('beerFrequency', 100);
            $table->string('numberOfShots', 100);
            $table->string('shotsFrequency', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalsocialhistory');
    }
};
