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
        Schema::create('target_quarterlies', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('target_id');
            $table->string('quarterly');
            $table->decimal('quarterly_percentage', 20, 2);
            $table->decimal('quarterly_target_value', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_quarterlies');
    }
};
