<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {


            $table->float('right_sphere')->nullable()->change();
            $table->float('right_cylinder')->nullable()->change();
            $table->float('right_axis')->nullable()->change();


            $table->float('left_sphere')->nullable()->change();
            $table->float('left_cylinder')->nullable()->change();
            $table->float('left_axis')->nullable()->change();

            
            $table->string('dosage')->nullable()->change();
            $table->string('medication_name')->nullable()->change();
            $table->string('effective_period')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {

            $table->float('right_sphere')->nullable(false)->change();
            $table->float('right_cylinder')->nullable(false)->change();
            $table->float('right_axis')->nullable(false)->change();

            $table->float('left_sphere')->nullable(false)->change();
            $table->float('left_cylinder')->nullable(false)->change();
            $table->float('left_axis')->nullable(false)->change();

            $table->string('dosage')->nullable(false)->change();
            $table->string('medication_name')->nullable(false)->change();
            $table->string('effective_period')->nullable(false)->change();
        });
    }
};
