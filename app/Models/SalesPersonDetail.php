<?php

namespace App\Models;

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
}
