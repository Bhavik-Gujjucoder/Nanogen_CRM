<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complain extends Model
{
    use SoftDeletes;
    protected $table = 'complain';
    protected $fillable = [
        'dd_id',
        'complain_image',
        'date',
        'product_id',
        'status',
        'description',
        'remark'
    ];

    public function distributorsDealers()
    {
        return $this->belongsTo(DistributorsDealers::class, 'dd_id');
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }

    /**
     * Get the user that owns the Complain
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function statusBadge()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-pill badge-status bg-danger">Pending</span>';
        }
        if ($this->status == 1) {
            return '<span class="badge badge-pill badge-status bg-purple">In Progress</span>';
        }
        if ($this->status == 2) {
            return '<span class="badge badge-pill badge-status bg-success">Under review</span>';
        }
        if ($this->status == 3) {
            return '<span class="badge badge-pill badge-status bg-info">Completed</span>';
        }
    }
}
