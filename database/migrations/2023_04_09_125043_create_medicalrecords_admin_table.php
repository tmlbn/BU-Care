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
            $table->text('xrayFindings');
            $table->text('cbcResults');
            $table->text('hepaBscreening');
            $table->text('bloodtype');
            $table->boolean('generalAppearance');
            $table->text('generalAppearanceDetails')->nullable()->default(null);
            $table->boolean('HEENT');
            $table->text('HEENTDetails')->nullable()->default(null);
            $table->boolean('chestLungs');
            $table->text('chestLungsDetails')->nullable()->default(null);
            $table->boolean('cardio');
            $table->text('cardioDetails')->nullable()->default(null);
            $table->boolean('abdomen');
            $table->text('abdomenDetails')->nullable()->default(null);
            $table->boolean('genito');
            $table->text('genitoDetails')->nullable()->default(null);
            $table->boolean('musculoskeletal');
            $table->text('musculoskeletalDetails')->nullable()->default(null);
            $table->boolean('nervousSystem');
            $table->text('nervousSystemDetails')->nullable()->default(null);
            $table->text('otherSignificantFindings')->nullable()->default(null);
            $table->text('fitness');
            $table->text('notfitPendingReason');
            $table->text('impression');
            $table->text('physician');
            $table->text('licenseNumber');
            $table->text('PTRnumber');
            $table->date('dateOfExam');
            $table->string('ticketID')->nullable()->default(null);
            $table->boolean('filled')->default(1);
            $table->boolean('released')->default(0);
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
