<?php

namespace App\Models;

use App\Models\CityManagement;
use App\Models\SalesDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPersonDetail extends Model
{
    use SoftDeletes;
    protected $table = 'sales_person_details';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function city()
    {
        return $this->hasOne(CityManagement::class, 'id', 'city_id');
    }
    public function head_quarter_city()
    {
        return $this->hasOne(CityManagement::class, 'id', 'head_quarter_city_id');
    }

    public function Department()
    {
        return $this->hasOne(SalesDepartment::class, 'id', 'department_id');
    }



    public function reportingUser()
    {
        return $this->belongsTo(User::class, 'reporting_sales_person_id', 'id');
    }
}
