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
            $table->foreign('MRPA_id')
                ->references('MRPA_id')->on('medicalrecordspersonnel_admin')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        
            $table->foreign('personnel_id')
                ->references('id')->on('users_personnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('familyhistory', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('immunizationhistory', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('pastillness', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('personalsocialhistory', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('presentillness', function (Blueprint $table) {
            $table->foreign('MR_id')
                ->references('MR_id')->on('medicalrecords')
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
        
        Schema::table('mrp_familyhistory', function (Blueprint $table) {
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('mrp_immunizationhistory', function (Blueprint $table) {
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('mrp_personalmedicalcondition', function (Blueprint $table) {
            $table->foreign('MRP_id')
                ->references('MRP_id')->on('medicalrecordspersonnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('mrp_personalsocialhistory', function (Blueprint $table) {
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
