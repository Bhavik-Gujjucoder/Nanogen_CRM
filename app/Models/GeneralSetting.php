<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';
    protected $fillable = [
        'company_logo',
        'company_email',
        'company_phone',
        'company_address',
        'distributor_payment_reminder_interval',
        'dealer_payment_reminder_interval',
    ];
}
