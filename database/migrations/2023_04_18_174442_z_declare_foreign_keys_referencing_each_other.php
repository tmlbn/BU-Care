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
        Schema::table('users_personnel', function (Blueprint $table) {
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        
                $table->foreign('MRPA_id')
                ->references('MRPA_id')->on('medicalrecordspersonnel_admin')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('users_students', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        
                $table->foreign('MRA_id')
                ->references('MRA_id')->on('medicalrecords_admin')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('medicalrecords', function (Blueprint $table) {
            $table->foreign('familyHistoryID')
                ->references('familyHistoryID')->on('familyhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('personalSocialHistoryID')
                ->references('personalSocialHistoryID')->on('personalsocialhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('pastIllnessID')
                ->references('pastIllnessID')->on('pastillness')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('presentIllnessID')
                ->references('presentIllnessID')->on('presentillness')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('immunizationHistoryID')
                ->references('immunizationHistoryID')->on('immunizationhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRA_id')
                ->references('MRA_id')->on('medicalrecords_admin')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        
            $table->foreign('student_id')
                ->references('id')->on('users_students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('medicalrecordspersonnel', function (Blueprint $table) {
            $table->foreign('MRP_familyHistoryID')
                ->references('MRP_familyHistoryID')->on('mrp_familyhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('MRP_personalSocialHistoryID')
                ->references('MRP_personalSocialHistoryID')->on('mrp_personalsocialhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRP_PMC_ID')
                ->references('MRP_PMC_ID')->on('mrp_personalmedicalcondition')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRP_immunizationHistoryID')
                ->references('MRP_immunizationHistoryID')->on('mrp_immunizationhistory')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRPA_id')
                ->references('MRPA_id')->on('medicalrecordspersonnel_admin')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        
            $table->foreign('personnel_id')
                ->references('id')->on('users_personnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('medicalrecords_admin', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        
            $table->foreign('student_id')
                ->references('id')->on('users_students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('medicalrecordspersonnel_admin', function (Blueprint $table) {
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        
            $table->foreign('personnel_id')
                ->references('id')->on('users_personnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('familyhistory', function (Blueprint $table){
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('immunizationhistory', function (Blueprint $table){
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('personalsocialhistory', function (Blueprint $table){
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('presentillness', function (Blueprint $table){
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('pastillness', function (Blueprint $table){
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('mrp_familyhistory', function (Blueprint $table){
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('mrp_immunizationhistory', function (Blueprint $table){
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('mrp_personalmedicalcondition', function (Blueprint $table){
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('mrp_personalsocialhistory', function (Blueprint $table){
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
