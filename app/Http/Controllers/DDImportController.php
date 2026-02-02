<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DistributorsDealersImport;

class DDImportController extends Controller
{
    public function import(Request $request)
    {
        $data['page_title'] = 'Import Distributors / Dealers';
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        return view('admin.distributors_dealers.import', $data);

        // Excel::import(new DistributorsDealersImport, $request->file('file'));

        // return back()->with('success', 'Distributors / Dealers imported successfully.');
    }

    public function import_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new DistributorsDealersImport, $request->file('file'));

        return back()->with('success', 'Distributors / Dealers imported successfully.');
    }
}
