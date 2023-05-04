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
        Schema::create('medicalrecordspersonnel_admin', function (Blueprint $table) {
            $table->bigIncrements('MRPA_id')->unique();
            $table->unsignedBigInteger('MRP_id')->unique();
            $table->unsignedBigInteger('personnel_id')->unique();
            $table->unsignedTinyInteger('bp_systolic');
            $table->unsignedTinyInteger('bp_diastolic');
            $table->unsignedTinyInteger('pulseRate');
            $table->unsignedTinyInteger('respirationRate');
            $table->float('temp', 8, 2);
            $table->string('o2saturation');
            $table->float('height', 8, 2);
            $table->unsignedSmallInteger('weight');
            $table->float('bmi', 8, 2);
            $table->text('chestXrayFinding');
            $table->text('CBCResults');
            $table->text('hepatitisBscreeningResults');
            $table->text('bloodtype');
            $table->text('recommendations');
            $table->text('physician');
            $table->boolean('released')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecordspersonnel_admin');
    }
};
