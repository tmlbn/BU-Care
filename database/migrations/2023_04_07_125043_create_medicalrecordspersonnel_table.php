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
        Schema::create('medicalrecordspersonnel', function (Blueprint $table) {
            $table->bigIncrements('MRP_id')->unique();
            $table->unsignedBigInteger('MRPA_id')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('personnel_id')->unique();
            $table->string('designation');
            $table->unsignedSmallInteger('unitDepartment');
            $table->string('campus');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->unsignedTinyInteger('age');
            $table->string('sex', 10);
            $table->string('gender', 20);
            $table->date('dateOfBirth');
            $table->string('civilStatus', 20);
            $table->string('nationality', 20);
            $table->string('religion', 50);
            $table->string('homeAddress');
            $table->unsignedBigInteger('contactNumber');
            $table->string('emergencyContactName', 100);
            $table->unsignedBigInteger('emergencyContactNumber');
            $table->string('emergencyContactOccupation', 100);
            $table->string('emergencyContactRelationship', 100);
            $table->string('emergencyContactAddress', 100);
            $table->unsignedBigInteger('MRP_familyHistoryID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MRP_personalSocialHistoryID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MRP_PMC_ID')->unique()->nullable()->default(null);
            $table->unsignedBigInteger('MRP_immunizationHistoryID')->unique()->nullable()->default(null);
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
            $table->string('resultName1', 50);
            $table->binary('resultImage1', 'mediumblob');
            $table->string('resultName2', 50);
            $table->binary('resultImage2', 'mediumblob');
            $table->string('resultName3', 50);
            $table->binary('resultImage3', 'mediumblob');
            $table->string('resultName4', 50);
            $table->binary('resultImage4', 'mediumblob');
            $table->string('resultName5', 50);
            $table->binary('resultImage5', 'mediumblob');
            $table->string('resultName6', 50);
            $table->binary('resultImage6', 'mediumblob');
            $table->string('resultName7', 50);
            $table->binary('resultImage7', 'mediumblob');
            $table->string('resultName8', 50);
            $table->binary('resultImage8', 'mediumblob');
            $table->boolean('signed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecordspersonnel');
    }
};
