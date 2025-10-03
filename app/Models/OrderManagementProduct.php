<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OrderManagement;
use App\Models\VariationOption;
use App\Models\ProductVariation; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class OrderManagementProduct extends Model
{
    protected $table = 'order_management_products';
    // protected $guarded = [];
    protected $fillable = [
        'order_id',
        'product_id',
        'gst',
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

//     public function productVariation()
// {
//     return $this->belongsTo(ProductVariation::class, 'packing_size_id', 'variation_option_id');
// }
    
}
