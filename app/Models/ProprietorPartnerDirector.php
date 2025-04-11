<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProprietorPartnerDirector extends Model
{
    protected $table = 'proprietor_partner_directors';
    protected $guarded = [];

    protected $casts = [
        'birthdate' => 'date',
    ];
}
