<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeManagement extends Model
{
    protected $table = 'grade_management';
    protected $guarded = [];
    public function statusBadge()
    {
        return $this->status == 1 ? '<span class="badge badge-pill badge-status bg-success">Active</span>' : '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
    }
}
