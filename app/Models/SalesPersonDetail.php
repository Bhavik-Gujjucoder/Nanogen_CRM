<?php

namespace App\Models;

use App\Models\CityManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPersonDetail extends Model
{
    use SoftDeletes;
    protected $table = 'sales_person_details';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function city()
    {
        return $this->hasOne(CityManagement::class, 'id','city_id');
    }

    // public function reporting_manager()
    // {
    //     return $this->hasMany(User::class, 'id','reporting_manager_id');
    // }
}
