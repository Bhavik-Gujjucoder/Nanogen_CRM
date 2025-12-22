<?php

use App\Models\GeneralSetting;
use App\Models\VariationOption;
use App\Models\ProductVariation;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\Auth;
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

// if (!function_exists('IndianNumberFormat')) {
//     function IndianNumberFormat($number) {
//         $number = (string)$number;
//         $lastThree = substr($number, -3);
//         $restUnits = substr($number, 0, -3);
//         if ($restUnits != '') {
//             $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
//             return '₹' . $restUnits . "," . $lastThree;
//         } else {
//             return '₹' . $lastThree;
//         }
//     }
// }
if (!function_exists('IndianNumberFormat')) {
    function IndianNumberFormat($number)
    {
        // Ensure it's numeric
        if (!is_numeric($number)) {
            return $number;
        }

        // Split integer and decimal
        $parts = explode('.', (string)$number);
        $integerPart = $parts[0];
        $decimalPart = isset($parts[1]) ? $parts[1] : '';

        // Format integer part in Indian numbering style
        $lastThree = substr($integerPart, -3);
        $restUnits = substr($integerPart, 0, -3);
        if ($restUnits != '') {
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . "," . $lastThree;
        } else {
            $formatted = $lastThree;
        }

        // Add decimal part if exists
        if ($decimalPart !== '') {
            return '₹' . $formatted . '.' . $decimalPart;
        } else {
            return '₹' . $formatted;
        }
    }
}

if (!function_exists('getSalesUserIdsOld')) {
    function getSalesUserIdsOld()
    {
        if (!auth()->user()->hasRole('sales')) {
            return [];
        }
        $login_user_id = Auth::user()->id;
        $login_user = Auth::user();

        // $reportingUserId = SalesPersonDetail::where('reporting_sales_person_id', $login_user_id)->pluck('user_id')->toArray();
        // dd($reportingUserId);
        $reportingUserId = optional($login_user->salesPersonDetail)->reporting_sales_person_id;

        return array_filter([
            $login_user_id,
            $reportingUserId
        ]);
    }
}


if (!function_exists('getReportManagerSalesPersonId')) {
    function getReportManagerSalesPersonId()
    {
        if (!auth()->user()->hasRole('reporting manager')) {
            return [];
        }
        $login_user_id = Auth::user()->id;

        $reportingUserId = SalesPersonDetail::where('reporting_manager_id', $login_user_id)->pluck('user_id')->toArray();
        return array_unique(
            array_merge(
                [$login_user_id],   // self
                $reportingUserId   // reporting sales persons who are reporting to reporting manager
            )
        );
    }
}


if (!function_exists('getSalesUserIds')) {
    function getSalesUserIds()
    {
        if (!auth()->user()->hasRole('sales')) {
            return [];
        }
        $login_user_id = Auth::user()->id;

        // $reportingUserId = SalesPersonDetail::where('reporting_sales_person_id', $login_user_id)->pluck('user_id')->toArray();
        $reportingUserId = SalesPersonDetail::where('user_id', $login_user_id)->pluck('reporting_sales_person_id')->toArray();

        return array_unique(
            array_merge(
                [$login_user_id],   // self
                $reportingUserId   // reporting sales persons who are reporting to their higher sales person
            )
        );
    }
}
