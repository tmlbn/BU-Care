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
        Schema::create('mrp_personalmedicalcondition', function (Blueprint $table) {
            $table->bigIncrements('MRP_PMC_ID')->unique();
            $table->boolean('hypertension');
            $table->boolean('asthma');
            $table->boolean('diabetes');
            $table->boolean('arthritis');
            $table->boolean('chickenPox');
            $table->boolean('dengue');
            $table->boolean('tuberculosis');
            $table->boolean('pneumonia');
            $table->boolean('covid19');
            $table->boolean('hivAids');
            $table->boolean('hepatitis');
            $table->string('hepatitisDetails', 100);
            $table->boolean('thyroidDisorder');
            $table->string('thyroidDisorderDetails', 100);
            $table->boolean('eyeDisorder');
            $table->string('eyeDisorderDetails', 100);
            $table->boolean('mentalDisorder');
            $table->string('mentalDisorderDetails', 100);
            $table->boolean('gastroDisease');
            $table->string('gastroDiseaseDetails', 100);
            $table->boolean('kidneyDisease');
            $table->string('kidneyDiseaseDetails', 100);
            $table->boolean('heartDisease');
            $table->string('heartDiseaseDetails', 100);
            $table->boolean('skinDisease');
            $table->string('skinDiseaseDetails', 100);
            $table->boolean('earDisease');
            $table->string('earDiseaseDetails', 100);
            $table->boolean('cancer');
            $table->string('cancerDetails', 100);
            $table->boolean('others');
            $table->string('othersDetails', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrp_personalmedicalcondition');
    }
};
