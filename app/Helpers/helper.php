<?php

use App\Models\GeneralSetting;
use App\Models\VariationOption;
use App\Models\ProductVariation;
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

if (!function_exists('getProductVariationOptions')) {
    function getProductVariationOptions($product_id)
    {
        return $product_variation = ProductVariation::with('variation_option_value')->where('product_id', $product_id)->get();
    }
}
