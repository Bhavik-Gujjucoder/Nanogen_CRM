<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProprietorPartnerDirector;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorsDealers extends Model
{
    // use SoftDeletes;
    protected $table = 'distributors_dealers';
    // protected $guarded = [];
    protected $fillable = [
        'profile_image',
        'user_type',
        'app_form_no',
        'code_no',
        'applicant_name',
        'firm_shop_name',
        'firm_shop_address',
        'mobile_no',
        'pancard',
        'gstin',
        'aadhar_card',
        'registered_dealer',
        'city_id',
        'state_id',
        'postal_code',
        'country_id',
        'bank_name_address',
        'account_no',
        'ifsc_code',
        'security_cheque_detail',
        'cheque_1',
        'cheque_2',
        'cheque_3',
        'name_authorised_signatory',
        'ac_type',
        'other_ac_type',
        'fertilizer_license',
        'pesticide_license',
        'seed_license',
        'firm_status',
        'associate_name_address',
        'indicate_number',
        'turnover1',
        'turnover2',
        'turnover3',
        'godown_facility',
        'godown_size_capacity',
        'godown_address',
        'expected_minimum_sales',
        'place',
        'date',
        'business_location',
        'godown_capacity_area',
        'godown_capacity_inbags',
        'godown_construction',
        'experience_capability',
        'financial_capability',
        'market_reputation',
        'business_potential',
        'market_potential',
        'minimum_turnover',
        'competitor_count',
        'cr_limit',
        'credit_limit',
        'credit_limit_type',
        'remarks',
        'employee_signature',
        'applicant_signature',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function dealership_companies()
    {
        return $this->hasMany(DealershipCompanies::class, 'dd_id', 'id');
    }

    public function proprietor_partner_director()
    {
        return $this->hasMany(ProprietorPartnerDirector::class, 'dd_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(DistributorsDealersDocuments::class, 'dd_id');
    }

    public function city()
    {
        return $this->hasOne(CityManagement::class, 'id','city_id');
    }
}
