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
        Schema::create('medicalrecords', function (Blueprint $table) {
            $table->bigIncrements('MR_id')->unique();
            $table->unsignedBigInteger('MRA_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('student_id')->unique();
            $table->string('campus');
            $table->string('course');
            $table->unsignedSmallInteger('SYstart');
            $table->unsignedSmallInteger('SYend');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->unsignedTinyInteger('age');
            $table->string('sex', 10);
            $table->date('dateOfBirth');
            $table->string('civilStatus', 20);
            $table->string('region');
            $table->string('province');
            $table->string('cityMunicipality');
            $table->string('barangaySubdVillage');
            $table->string('houseNumberStName');
            $table->string('nationality', 20);
            $table->string('religion', 50);
            $table->string('fatherName', 100);
            $table->string('fatherOccupation', 100);
            $table->string('fatherOfficeAddress', 100);
            $table->string('motherName', 100);
            $table->string('motherOccupation', 100);
            $table->string('motherOfficeAddress', 100);
            $table->string('guardianName', 100);
            $table->string('guardianAddress', 100);
            $table->bigInteger('parentGuardianContactNumber');
            $table->bigInteger('studentContactNumber');
            $table->string('emergencyContactName', 100);
            $table->bigInteger('emergencyContactNumber');
            $table->string('emergencyContactOccupation', 100);
            $table->string('emergencyContactRelationship', 100);
            $table->string('emergencyContactAddress', 100);
            $table->unsignedBigInteger('familyHistoryID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('personalSocialHistoryID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('pastIllnessID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('presentIllnessID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('immunizationHistoryID')->unique()->nullable()->default(null);
            $table->boolean('hospitalization');
            $table->string('hospDetails', 100);
            $table->boolean('takingMedsRegularly', 20);
            $table->string('medsDetails', 20);
            $table->boolean('allergic', 20);
            $table->string('allergyDetails', 20);
            $table->binary('chestXray', 'mediumblob');
            $table->binary('CBCResults', 'mediumblob');
            $table->binary('hepaBscreening', 'mediumblob');
            $table->binary('bloodType', 'mediumblob');
            $table->string('resultName1', 50)->nullable()->default(null);
            $table->binary('resultImage1', 'mediumblob')->nullable()->default(null);
            $table->string('resultName2', 50)->nullable()->default(null);
            $table->binary('resultImage2', 'mediumblob')->nullable()->default(null);
            $table->string('resultName3', 50)->nullable()->default(null);
            $table->binary('resultImage3', 'mediumblob')->nullable()->default(null);
            $table->string('resultName4', 50)->nullable()->default(null);
            $table->binary('resultImage4', 'mediumblob')->nullable()->default(null);
            $table->string('resultName5', 50)->nullable()->default(null);
            $table->binary('resultImage5', 'mediumblob')->nullable()->default(null);
            $table->string('resultName6', 50)->nullable()->default(null);
            $table->binary('resultImage6', 'mediumblob')->nullable()->default(null);
            $table->string('resultName7', 50)->nullable()->default(null);
            $table->binary('resultImage7', 'mediumblob')->nullable()->default(null);
            $table->string('resultName8', 50)->nullable()->default(null);
            $table->binary('resultImage8', 'mediumblob')->nullable()->default(null);
            $table->boolean('signed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecords');
    }
};
