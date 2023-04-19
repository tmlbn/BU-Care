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
        Schema::create('mpr_illness', function (Blueprint $table) {
            $table->bigIncrements('MPR_illnessID')->unique();
            $table->unsignedBigInteger('MPR_id')->unique();
            $table->boolean('hypertension');
            $table->boolean('asthma');
            $table->boolean('mumps');
            $table->boolean('diabetes');
            $table->boolean('rheumatic_fever');
            $table->boolean('cardiac_disease');
            $table->boolean('kidney_disease');
            $table->boolean('seizure_disorder');
            $table->boolean('chicken_pox');
            $table->boolean('measles');
            $table->boolean('hepatitis');
            $table->boolean('tuberculosis');
            $table->boolean('diphteria');
            $table->boolean('allergy');
            $table->string('allergyDetails', 100);
            $table->string('others');
            $table->timestamps();
        });

        Schema::table('medicalpatientrecords', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')->on('users_students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('personnel_id')
                ->references('id')->on('users_personnel')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('MPR_illnessID')
                ->references('MPR_illnessID')->on('mpr_illness')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
        
        Schema::table('mpr_illness', function (Blueprint $table) {
            $table->foreign('MPR_id')
                ->references('MPR_id')->on('medicalpatientrecords')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpr_illness');
    }
};
