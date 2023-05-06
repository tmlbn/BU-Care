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
            $table->text('unitDepartment');
            $table->string('campus');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->unsignedTinyInteger('age');
            $table->string('sex', 10);
            $table->string('gender', 20);
            $table->boolean('pwd');
            $table->date('dateOfBirth');
            $table->string('civilStatus', 20);
            $table->string('nationality', 20);
            $table->string('religion', 50);
            $table->string('region');
            $table->string('province');
            $table->string('cityMunicipality');
            $table->string('barangaySubdVillage');
            $table->string('houseNumberStName');
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
            $table->text('hospDetails');
            $table->boolean('takingMedsRegularly', 20);
            $table->text('medsDetails');
            $table->boolean('allergic', 20);
            $table->text('allergyDetails');
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
        Schema::dropIfExists('medicalrecordspersonnel');
    }
};
