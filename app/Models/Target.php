<?php

namespace App\Models;

use App\Models\CityManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
