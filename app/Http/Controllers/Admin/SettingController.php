<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::getSettings(SiteSetting::HOME_SECTION_DEFAULTS);

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settingsToUpdate = [];

        foreach (array_keys(SiteSetting::HOME_SECTION_DEFAULTS) as $key) {
            if (array_key_exists($key, $request->all())) {
                $settingsToUpdate[$key] = $request->boolean($key);
            }
        }

        if ($settingsToUpdate !== []) {
            SiteSetting::setSettings($settingsToUpdate);
        }

        return back()->with('success', 'Homepage visibility settings updated.');
    }
}
