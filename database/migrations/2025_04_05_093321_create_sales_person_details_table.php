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
        Schema::create('sales_person_details', function (Blueprint $table) {
            $table->id();
            // Basic info
            $table->string('first_name');
            $table->string('last_name');

            // Job details fields badha aavi gya ae conform kari levas
            $table->string('employee_id')->unique();
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('position_id')->nullable();
            $table->bigInteger('reporting_manager_id')->nullable();
            $table->date('date')->nullable();

            // Address
            $table->text('street_address')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->bigInteger('country_id')->nullable();

             // timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_person_details');
    }
};
