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
        Schema::create('users_clinic', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id_number', 15)->unique();
            $table->string('password', 60);
            $table->string('last_name', 30);
            $table->string('first_name', 30);
            $table->string('middle_name', 30);
            $table->string('email', 50)->unique();
            $table->string('user_type', 11)->default('STAFF');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_clinic');
    }
};
