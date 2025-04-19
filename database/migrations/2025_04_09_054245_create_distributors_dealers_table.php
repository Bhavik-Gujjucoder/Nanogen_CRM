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
        Schema::create('distributors_dealers', function (Blueprint $table) {
            $table->id();
            $table->string('profile_image')->nullable();
            $table->string('user_type');
            $table->string('app_form_no');
            $table->string('code_no');
            $table->string('applicant_name');
            $table->string('firm_shop_name');
            $table->text('firm_shop_address');
            $table->string('mobile_no');
            $table->string('pancard');
            $table->string('gstin')->nullable();
            $table->string('aadhar_card');
            $table->string('registered_dealer');
            $table->text('bank_name_address');
            $table->string('account_no');
            $table->string('ifsc_code');
            $table->string('security_cheque_detail')->nullable();
            $table->string('cheque_1')->nullable();
            $table->string('cheque_2')->nullable();
            $table->string('cheque_3')->nullable();
            $table->string('name_authorised_signatory')->nullable();
            $table->string('ac_type')->nullable();
            $table->string('other_ac_type')->nullable();
            $table->text('fertilizer_license')->nullable();
            $table->text('pesticide_license')->nullable();
            $table->text('seed_license')->nullable();
            $table->string('product_id')->nullable();
            $table->string('firm_status')->nullable();
            $table->text('associate_name_address')->nullable();
            $table->string('indicate_number')->nullable();
            $table->text('turnover1')->nullable();
            $table->text('turnover2')->nullable();
            $table->text('turnover3')->nullable();
            $table->string('godown_facility')->nullable();
            $table->text('expected_minimum_sales')->nullable();
            $table->string('place')->nullable();
            $table->date('date')->nullable();
            $table->text('employee_signature')->nullable();
            $table->text('applicant_signature')->nullable();
            $table->string('business_location')->nullable();
            $table->string('godown_size_capacity')->nullable();
            $table->string('godown_address')->nullable();
            $table->string('godown_capacity_area')->nullable();
            $table->string('godown_capacity_inbags')->nullable();
            $table->string('godown_construction')->nullable();
            $table->text('experience_capability')->nullable();
            $table->text('financial_capability')->nullable();
            $table->string('market_reputation')->nullable();
            $table->text('business_potential')->nullable();
            $table->text('market_potential')->nullable();
            $table->text('minimum_turnover')->nullable();
            $table->string('competitor_count')->nullable();
            $table->string('cr_limit')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('credit_limit_type')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors_dealers');
    }
};
