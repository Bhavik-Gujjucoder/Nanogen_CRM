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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->nullable()->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('is_parent')->default(0); // is_parent: TINYINT default 0
            $table->bigInteger('parent_category_id')->nullable(); // parent_category_id: BIGINT, nullable
            $table->integer('status')->default(1); // status: INTEGER default 1
            $table->timestamps(); // created_at and updated_at columns
            $table->softDeletes(); // deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
