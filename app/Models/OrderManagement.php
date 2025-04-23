<?php

namespace App\Models;

use App\Models\DistributorsDealers;
use App\Models\OrderManagementProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        switch ($this->status) {
            case 1:
                return '<span class="badge badge-pill badge-status bg-secondary">Pending</span>';
            case 2:
                return '<span class="badge badge-pill badge-status bg-warning">Processing</span>';
            case 3:
                return '<span class="badge badge-pill badge-status bg-info">Shipping</span>';
            case 4:
                return '<span class="badge badge-pill badge-status bg-success">Delivered</span>';
            default:
                return '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
        }
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
    public function sales_person_detail(): HasOne
    {
        return $this->hasOne(SalesPersonDetail::class, 'user_id', 'salesman_id');
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
