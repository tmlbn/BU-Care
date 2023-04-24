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
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('personalSocialHistoryID')
                ->references('personalSocialHistoryID')->on('personalsocialhistory')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('pastIllnessID')
                ->references('pastIllnessID')->on('pastillness')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('presentIllnessID')
                ->references('presentIllnessID')->on('presentillness')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('immunizationHistoryID')
                ->references('immunizationHistoryID')->on('immunizationhistory')
                ->cascadeOnDelete()
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
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('MRP_personalSocialHistoryID')
                ->references('MRP_personalSocialHistoryID')->on('mrp_personalsocialhistory')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRP_PMC_ID')
                ->references('MRP_PMC_ID')->on('mrp_personalmedicalcondition')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRP_immunizationHistoryID')
                ->references('MRP_immunizationHistoryID')->on('mrp_immunizationhistory')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('MRPA_id')
                ->references('MRPA_id')->on('medicalrecordspersonnel_admin')
                ->cascadeOnDelete()
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
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
