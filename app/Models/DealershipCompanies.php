<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealershipCompanies extends Model
{
    protected $table = 'dealership_companies';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
