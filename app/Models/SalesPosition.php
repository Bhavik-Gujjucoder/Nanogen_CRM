<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPosition extends Model
{
    protected $table = 'sales_positions';
    protected $guarded = [];

    public function statusBadge()
    {
        return $this->status == 1 ? '<span class="badge badge-pill badge-status bg-success">Active</span>' : '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
    }
}
