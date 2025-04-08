<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\VariationOption;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Pricing and Product Variation';
        if ($request->ajax()) {
            $data = Variation::with('variant_options');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item variation_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="' . route('variation.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteVariation"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('variation.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })
                ->addColumn('value', function ($variation) {
                    return $variation->variant_options->isNotEmpty() ? $variation->variant_options->pluck('value')->implode(', ') : '-';
                })
                ->filterColumn('value', function ($query, $keyword) {
                    $query->whereHas('variant_options', function ($q) use ($keyword) {
                        $q->where('value', 'LIKE', "%{$keyword}%");
                    });
                })
                ->editColumn('status', function ($category) {
                    return $category->statusBadge();
                })
                ->rawColumns(['checkbox', 'action', 'value', 'status'])
                ->make(true);
        }

        return view('admin.variation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create Pricing and Product Variation';
        return view('admin.variation.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name   = $request->name;
        $weight = $request->weight;
        if ($name) {
            $variation =  Variation::create([
                'name'   => $name,
                'status' => $request->status,
            ]);
        }

        if (!empty($weight) && isset($variation)) {
            foreach ($weight as $weightValue) {
                VariationOption::create([
                    'variation_id' => $variation->id,
                    'value'  => $weightValue,
                ]);
            }
        }

        return redirect()->route('variation.index')->with('success', 'Variation created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title'] = 'Edit Pricing and Product Variation';
        $data['variation']  = Variation::with('variant_options')->where('id', $id)->firstOrFail();
        // dd($data['variations']);
        return view('admin.variation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name      = $request->name;
        $weight    = $request->weight;
        $variation = Variation::findOrFail($id);
        $variation->update([
            'name'   => $name,
            'status' => $request->status
        ]);

        VariationOption::where('variation_id', $id)->delete();

        if (!empty($weight) && isset($variation)) {
            foreach ($weight as $weightValue) {
                VariationOption::create([
                    'variation_id' => $variation->id,
                    'value' => $weightValue,
                ]);
            }
        }

        return redirect()->route('variation.index')->with('success', 'Variation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variation = Variation::findOrFail($id);
        VariationOption::where('variation_id', $id)->delete();
        $variation->delete();
        return redirect()->route('variation.index')->with('success', 'Variation deleted successfully!');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Variation::whereIn('id', $ids)->delete();
            VariationOption::whereIn('variation_id', $ids)->delete();
            return response()->json(['message' => 'Selected variations deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }

    public function get_variation_value(Request $request)
    {
        $VariationOption = VariationOption::where('variation_id', $request->variation_id)->get();

        if ($VariationOption->isNotEmpty()) {
            return response()->json(['success' => true, 'variations' => $VariationOption]);
        } else {
            return response()->json(['success' => false, 'message' => 'No sizes found']);
        }
    }
}
