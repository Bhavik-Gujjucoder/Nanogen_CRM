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
        Schema::create('target_grades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id');
            $table->bigInteger('grade_id');
            $table->text('percentage');
            $table->text('percentage_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_grades');
    }
};
