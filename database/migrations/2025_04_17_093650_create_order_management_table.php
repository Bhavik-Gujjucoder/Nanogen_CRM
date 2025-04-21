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
        Schema::create('order_management', function (Blueprint $table) {
            $table->id();
            $table->string('unique_order_id')->nullable();
            $table->integer('dd_id')->comment('distributors_dealers -> id');                // distributors & dealers
            $table->date('order_date')->nullable();
            $table->string('mobile_no');
            $table->integer('salesman_id');
            $table->string('transport');
            $table->string('freight'); 
            $table->string('gst_no');
            $table->text('address');
            $table->double('total_order_amount');
            $table->integer('gst');
            $table->double('gst_amount');
            $table->double('grand_total');
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_management');
    }
};
