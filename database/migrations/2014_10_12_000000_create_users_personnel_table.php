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
            $table->id()->unique();
            $table->string('personnel_id_number', 20)->unique();
            $table->string('email', 50);
            $table->string('password');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->date('date_of_birth');
            $table->unsignedBigInteger('MRP_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MRPA_id')->unique()->nullable()->default(null);
            $table->boolean('hasMedRecord')->nullable()->default(false);
            $table->boolean('hasValidatedRecord')->nullable()->default(false);
            $table->string('user_type', 17)->default('PATIENT/PERSONNEL');
            $table->rememberToken();
            $table->timestamps();
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
