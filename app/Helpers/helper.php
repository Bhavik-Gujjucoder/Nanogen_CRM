<?php

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\File;

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $value = GeneralSetting::where('key', $key)->first()->value ?? '';
        return $value;
    }
}
