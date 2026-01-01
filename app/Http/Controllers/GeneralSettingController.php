<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\DistributorsDealers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Category;

class GeneralSettingController extends Controller
{
    public function create()
    {
        $data['page_title'] = 'Settings';
        $data['setting']    = GeneralSetting::get();
        return view('admin.generalsetting.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->form_type == 'company-detail') {
            $request->validate([
                'company_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'company_email'   => 'required|email',
                'company_phone'   => 'required',
                'company_address' => 'required',
                // 'distributor_payment_reminder_interval' => 'required',
                // 'dealer_payment_reminder_interval'      => 'required',
                'gst'             => 'required',
            ]);
        } elseif ($request->form_type == 'general-setting') {
            $request->validate([
                'login_page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'copyright_msg'    => 'required',
            ]);
        } elseif ($request->form_type == 'parent-category') {
            // $request->validate([
            //     // 'login_page_image' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //     // 'copyright_msg'    => 'required',
            // ]);

            // $is_parent = 1;

            // Category::create([
            //     'parent_category_id' => $request->parent_category_id,
            //     'category_name' => $request->category_name,
            //     'status'        => $request->status,
            //     'is_parent'     => $is_parent,
            //     'parent_category_id' => '0' 
            // ]);

            return response()->json(['success' => true, 'message' => 'Category created successfully']);
        } elseif ($request->form_type == 'email-detail') {
            $request->validate([
                'email_template_header' => 'required',
                'email_template_footer' => 'required',
            ]);
        } elseif ($request->form_type == 'distributors-dealers') {
            $request->validate([
                'distributor_credit_limit' => 'required',
                'dealer_credit_limit' => 'required',
            ]);
        } elseif ($request->form_type == 'o_form') {
            $request->validate([
                'o_form_docx_file'  => 'required|file|mimes:docx',
            ], [
                'o_form_docx_file.required' => 'The o form docx file is required.'
            ]);
        } elseif ($request->form_type == 'principal_certificate') {
            $request->validate([
                'principal_certificate_docx_file'  => 'required|file|mimes:docx',
            ], [
                'principal_certificate_docx_file.required' => 'The Principal Certificate docx file is required.'
            ]);
        } elseif ($request->form_type == 'advance-payment-discount') {
            $request->validate([
                'advance_payment_discount' => 'required',
                'discount_type' => 'required',
            ]);
        } else {
            // 
        }

        $data = $request->except('_token');
        $data = $request->except('company_logo');
        $data = $request->except('login_page_image');
        $data = $request->except('o_form_docx_file');
        $data = $request->except('principal_certificate_docx_file');

        if (!$data) {
            return redirect()->back()->with('error', 'Request data is empty.');
        } else {
            $data = $request->except(['_token', 'company_logo', 'login_page_image', 'form_type']);
            // dd($data);
            foreach ($data as $key => $value) {
                // GeneralSetting::where('key', $key)->update(['value' => $value]);
                GeneralSetting::updateOrCreate(
                    ['key' => $key],         /* Search by key */
                    ['value' => $value]      /* Update or set value */
                );
            }

            if ($request->hasFile('company_logo')) {
                $general_setting = GeneralSetting::where('key', 'company_logo')->first();
                /* Delete old profile picture if exists */
                if ($request->company_logo) {
                    Storage::disk('public')->delete('company_logo/' . $general_setting->company_logo);
                }
                /* Upload new profile picture */
                $file = $request->file('company_logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('company_logo', $filename, 'public');  /* Save in storage/app/public/company_logo */

                /* Save new filename in database */
                $general_setting->value = $filename;
                $general_setting->save();
            }

            if ($request->hasFile('login_page_image')) {

                // $general_setting = GeneralSetting::where('key', 'login_page_image')->first();
                $general_setting = GeneralSetting::firstOrNew(['key' => 'login_page_image']);
                /* Delete old profile picture if exists */
                if (isset($request->login_page_image) && $general_setting && $general_setting->login_page_image) {
                    Storage::disk('public')->delete('login_page_image/' . $general_setting->login_page_image);
                }
                /* Upload new profile picture */
                $file = $request->file('login_page_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('login_page_image', $filename, 'public');  /* Save in storage/app/public/login_page_image */

                /* Save new filename in database */
                $general_setting->value = $filename ?? '';
                $general_setting->save();
            }

            if ($request->hasFile('o_form_docx_file')) {
                $general_setting = GeneralSetting::where('key', 'o_form_docx_file')->first();
                /* Delete old profile picture if exists */
                if ($general_setting) {
                    Storage::disk('public')->delete('O-Form/' . $general_setting->value);
                }
                /* Upload new profile picture */
                $file = $request->file('o_form_docx_file');
                // $filename = time() . '_' . $file->getClientOriginalName();
                $filename = 'NANOGEN-O-FORM.docx';

                $file->storeAs('O-Form', $filename, 'public');  /* Save in storage/app/public/O-Form */

                /* Save new filename in database */
                $general_setting->value = $filename;
                $general_setting->save();
            }

            if ($request->hasFile('principal_certificate_docx_file')) {
                $general_setting = GeneralSetting::where('key', 'principal_certificate_docx_file')->first();
                /* Delete old profile picture if exists */
                if ($general_setting) {
                    Storage::disk('public')->delete('PRINCIPAL-CERTIFICATE/' . $general_setting->value);
                }
                /* Upload new profile picture */
                $file = $request->file('principal_certificate_docx_file');
                // $filename = time() . '_' . $file->getClientOriginalName();
                $filename = 'NANOGEN-PRINCIPAL-CERTIFICATE.docx';

                $file->storeAs('PRINCIPAL-CERTIFICATE', $filename, 'public');  /* Save in storage/app/public/O-Form */

                /* Save new filename in database */
                $general_setting->value = $filename;
                $general_setting->save();
            }

            return redirect()->back()->withSuccess('Setting update successfully.');
        }
    }
}
