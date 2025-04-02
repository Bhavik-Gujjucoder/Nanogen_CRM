<?php

use App\Models\GeneralSetting;
use App\Models\VariationOption;
use Illuminate\Support\Facades\File;

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $value = GeneralSetting::where('key', $key)->first()->value ?? '';
        return $value;
    }
}

if (!function_exists('getVariationOptions')) {
    function getVariationOptions($variation_id)
    {
        return VariationOption::where('variation_id', $variation_id)->get();
    }
}
