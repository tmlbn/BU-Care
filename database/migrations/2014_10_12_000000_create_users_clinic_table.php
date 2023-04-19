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
            $table->id()->unique();
            $table->string('staff_id_number', 20)->unique();
            $table->string('email', 50);
            $table->string('password');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->date('date_of_birth');
            $table->string('user_type', 12)->default('ADMIN/CLINIC');
            $table->rememberToken();
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
