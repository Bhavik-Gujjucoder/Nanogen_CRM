<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplainStatusHistory extends Model
{
    protected $table = 'complain_status_history';
    protected $fillable = [
        'complain_id',
        'status',
        'remark'
    ];
}
