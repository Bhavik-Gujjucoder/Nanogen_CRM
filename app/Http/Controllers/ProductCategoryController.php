<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Product Category';
        return view('admin.productcategory.index', $data);
    }
}
