<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetGrade extends Model
{
    protected $table = 'target_grades';
    // protected $guarded = [];
    protected $fillable = [
        'target_id',
        'target_quarterly_id',
        'grade_id',
        'grade_percentage',
        'grade_target_value',
    ];


    public function grade()
    {
        return $this->hasOne(GradeManagement::class, 'id','grade_id');
    }

        public function quarter()
    {
        return $this->hasOne(TargetQuarterly::class, 'id','target_quarterly_id');
    }
}
