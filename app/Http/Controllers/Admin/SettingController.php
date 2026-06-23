<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show general settings and ad settings form.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $keys = [
            'site_name',
            'site_title',
            'site_description',
            'site_keywords',
            'google_analytics_id',
            'ad_header',
            'ad_content',
            'ad_sidebar',
            'ad_footer',
            'ad_sticky'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::setValue($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'System configurations updated successfully.');
    }
}
