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
        Schema::table('distributors_dealers', function (Blueprint $table) {
            $table->bigInteger('city_id')->nullable()->after('registered_dealer');
            $table->bigInteger('state_id')->nullable()->after('city_id');
            $table->string('postal_code')->nullable()->after('state_id');
            $table->bigInteger('country_id')->nullable()->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributors_dealers', function (Blueprint $table) {
            $table->dropColumn(['city_id', 'state_id', 'postal_code', 'country_id']);
        });
    }
};
