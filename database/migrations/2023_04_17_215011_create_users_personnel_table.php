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
        Schema::create('users_personnel', function (Blueprint $table) {
            $table->id();
            $table->string('personnel_id_number', 20);
            $table->string('email', 70);
            $table->string('password', 60);
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('birth_month', 9);
            $table->unsignedTinyInteger('birth_date');
            $table->unsignedSmallInteger('birth_year');
            $table->timestamps();
            $table->unsignedBigInteger('PMR_id')->nullable();
            $table->unsignedBigInteger('PMRA_id')->nullable();
            $table->tinyInteger('hasMedRecord')->nullable();
            $table->tinyInteger('hasValidatedRecord')->nullable();
            $table->string('user_type', 10)->default('PATIENT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_personnel');
    }
};
