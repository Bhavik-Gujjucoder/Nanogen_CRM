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
        Schema::create('complain', function (Blueprint $table) {
            $table->id();
            $table->integer('dd_id');
            $table->text('complain_image');
            $table->text('date');
            $table->integer('product_id');
            $table->tinyInteger('status');
            $table->longText('description');
            $table->longText('remark');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complain');
    }
};
