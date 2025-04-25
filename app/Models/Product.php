<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [];

    public function statusBadge()
    {
        return $this->status == 1 ? '<span class="badge badge-pill badge-status bg-success">Active</span>' : '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id','category_id');
    }

    public function grade()
    {
        return $this->hasOne(GradeManagement::class, 'id','grade_id');
    }

    public function product_variations()
    {
        return $this->hasMany(ProductVariation::class);  // 'product_id' is the foreign key in the ProductVariation table
    }

    public function getAllVariationOptionValuesAttribute()
    {
        return $this->product_variations->map(function ($variation) {
                    return $variation->variation_option_value?->value;
                })->filter() // removes nulls if any
                ->values();  // reset array keys
    }

    
}
