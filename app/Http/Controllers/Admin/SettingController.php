<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Session;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('hidden', 'No')->orderBy('id', 'desc')->paginate(Session::get('pagination'));

        return view('admin.list_setting')->with('settings', $settings);
    }

    public function edit(Setting $setting)
    {
        return view('admin.edit_setting')->with('setting', $setting);
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        if ($setting->key == 'date') {
            $search  = ['y', 'm', 'd', 'j'];
            $replace = ['YYYY', 'MM', 'DD', 'DD'];
            $subject = strtolower($request->value);
            $jqueryDate = str_replace($search, $replace, $subject);
            Setting::updateOrCreate(['key' => 'jquerydate'], ['value' => $jqueryDate, 'hidden' => 'Yes']);
        }

        Session::put($setting->key, $request->value);
        $setting->update([
            'value' =>  $request->value
        ]);
        
        return redirect()->route('admin.settings')->with('success', __('setting.messages.settingUpdated'));
    }
}
