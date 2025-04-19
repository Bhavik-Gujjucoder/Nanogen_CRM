<?php

namespace App\Models;

use App\Models\DistributorsDealers;
use App\Models\OrderManagementProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderManagement extends Model
{
    protected $table = 'order_management';
    protected $guarded = [];
    protected $casts = [
        'order_date' => 'date'
    ];
    
    public function statusBadge()
    {
        return $this->status == 1 ? '<span class="badge badge-pill badge-status bg-success">Active</span>' : '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
    }


    /**
     * Get the user that owns the OrderManagement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distributors_dealers(): BelongsTo
    {
        return $this->belongsTo(DistributorsDealers::class, 'dd_id', 'id');
    }

    /**
     * Get the user that owns the OrderManagement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salesman(): BelongsTo
    {
        return $this->belongsTo(SalesPersonDetail::class, 'salesman_id', 'id');
    }


        /**
         * Get all of the comments for the OrderManagement
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function products(): HasMany
        {
            return $this->hasMany(OrderManagementProduct::class, 'order_id', 'id');
        }

}
