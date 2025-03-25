<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    public function create()
    {
        $data['page_title'] = 'Settings';
        $data['setting'] = GeneralSetting::get();
        return view('admin.generalsetting.create', $data);
    }

    public function store(Request $request)
    {
        if ($request->form_type == 'company-detail') {
            $request->validate([
                'company_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'company_email'   => 'required|email',
                'company_phone'   => 'required',
                'company_address' => 'required',
                'distributor_payment_reminder_interval' => 'required',
                'dealer_payment_reminder_interval'      => 'required',
            ]);
        } elseif ($request->form_type == 'email-detail') {
            $request->validate([
                'email_template_header' => 'required',
                'email_template_footer' => 'required',
            ]);
        }
        $data = $request->except('_token');
        $data = $request->except('company_logo');
        if (!$data) {
            return redirect()->back()->with('error', 'Request data is empty.');
        } else {

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


            foreach ($data as $key => $value) {
                GeneralSetting::where('key', $key)->update(['value' => $value]);
            }


            return redirect()->back()->withSuccess('Setting update successfully.');
        }
    }
}
