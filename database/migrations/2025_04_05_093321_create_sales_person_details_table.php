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

             // Job details
             $table->string('employee_id')->unique();
             $table->string('department')->nullable();
             $table->string('position')->nullable();
             $table->bigInteger('reporting_manager')->nullable();
             $table->date('joining_date')->nullable();

             // Address
             $table->text('street_address')->nullable();
             $table->integer('city')->nullable();
             $table->integer('state')->nullable();
             $table->string('postal_code')->nullable();
             $table->string('country')->nullable();
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
