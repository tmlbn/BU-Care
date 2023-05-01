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
        Schema::create('medicalrecords_admin', function (Blueprint $table) {
            $table->bigIncrements('MRA_id')->unique();
            $table->unsignedBigInteger('MR_id')->unique();
            $table->unsignedBigInteger('student_id')->unique();
            $table->unsignedTinyInteger('bp_systolic');
            $table->unsignedTinyInteger('bp_diastolic');
            $table->unsignedTinyInteger('pulseRate');
            $table->unsignedTinyInteger('respirationRate');
            $table->float('temp', 8, 2);
            $table->float('height', 8, 2);
            $table->unsignedSmallInteger('weight');
            $table->float('bmi', 8, 2);
            $table->string('xrayFindings');
            $table->string('cbcResults');
            $table->string('hepaBscreening');
            $table->string('bloodtype');
            $table->string('generalAppearance');
            $table->string('HEENT');
            $table->string('chestLungs');
            $table->string('cardio');
            $table->string('abdomen');
            $table->string('genito');
            $table->string('musculoskeletal');
            $table->string('nervousSystem');
            $table->string('otherSignificantFindings');
            $table->string('fitness', 7);
            $table->string('notfitPendingReason');
            $table->string('impression');
            $table->string('licenseNumber');
            $table->string('PTRnumber');
            $table->date('dateOfExam');
            $table->text('physician');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecords_admin');
    }
};
