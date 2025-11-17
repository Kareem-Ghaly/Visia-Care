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
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('appointments', 'end_date')) {
                $table->dropColumn('end_date');

            }
            $table->foreignId('availability_id')
                  ->nullable()
                  ->after('patient_profile_id')
                  ->constrained('doctor_availabilities')
                  ->onDelete('cascade');

            $table->date('appointment_date')->after('availability_id');
            $table->time('appointment_time')->after('appointment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['availability_id']);
            $table->dropColumn(['availability_id', 'appointment_date', 'appointment_time']);
  $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
        });
    }
};
