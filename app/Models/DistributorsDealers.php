<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorsDealers extends Model
{
    use SoftDeletes;
    protected $table = 'distributors_dealers';
    protected $guarded = [];

}
