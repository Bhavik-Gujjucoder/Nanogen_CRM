<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetGrade extends Model
{
    protected $table = 'target_grades';
    protected $guarded = [];


    public function grade()
    {
        return $this->hasOne(GradeManagement::class, 'id','grade_id');
    }
}
