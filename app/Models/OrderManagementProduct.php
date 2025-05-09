<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OrderManagement;
use App\Models\VariationOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class OrderManagementProduct extends Model
{
    protected $table = 'order_management_products';
    // protected $guarded = [];
    protected $fillable = [
        'order_id',
        'product_id',
        'packing_size_id',
        'price',
        'qty',
        'total'
    ];

    /**
     * Get all of the comments for the OrderManagement
     *
     * @return hasOne
     */
    public function variation_option(): hasOne
    {
        return $this->hasOne(VariationOption::class, 'id', 'packing_size_id');
    }

    /**
     * Get all of the products for the OrderManagementProduct
     *
     * @return hasOne
     */
    public function product(): hasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(OrderManagement::class, 'order_id');
    }
    
}
