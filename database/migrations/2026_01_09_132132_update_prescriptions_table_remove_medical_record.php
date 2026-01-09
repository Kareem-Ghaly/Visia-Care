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
         Schema::table('prescriptions', function (Blueprint $table) {
       
        $table->foreignId('patient_profile_id')
              ->after('doctor_id')
              ->constrained('patient_profiles')
              ->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {

        $table->dropForeign(['patient_profile_id']);
        $table->dropColumn('patient_profile_id');
    });
    }
};
