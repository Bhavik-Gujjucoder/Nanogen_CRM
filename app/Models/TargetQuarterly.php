<?php

namespace App\Models;

use App\Models\TargetGrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TargetQuarterly extends Model
{
    protected $table = 'target_quarterlies';
    protected $fillable = [
        'target_id',
        'quarterly',
        'quarterly_percentage',
        'quarterly_target_value',
    ];

        public function target_grade(): HasMany
    {
        return $this->hasMany(TargetGrade::class, 'target_quarterly_id', 'id');
    }
}
