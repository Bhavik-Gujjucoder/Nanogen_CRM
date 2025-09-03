<?php

namespace App\Models;

use App\Models\TargetGrade;
use App\Models\CityManagement;
use App\Models\TargetQuarterly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Target extends Model
{
    protected $table = 'targets';
    protected $guarded = [];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function sales_person_detail(): HasOne
    {
        return $this->hasOne(SalesPersonDetail::class, 'user_id', 'salesman_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(CityManagement::class, 'id', 'city_id');
    }

    /**
     * Get all of the comments for the Target
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function target_grade(): HasMany
    {
        return $this->hasMany(TargetGrade::class, 'target_id', 'id');
    }

    /**
     * Get all of the comments for the Target
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function target_quarterly(): HasMany
    {
        return $this->hasMany(TargetQuarterly::class, 'target_id', 'id');
    }



}

