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

        $request->validate([
            'home_packages_layout' => ['nullable', 'in:tabs,grid'],
        ]);

        foreach (SiteSetting::HOME_SECTION_DEFAULTS as $key => $defaultValue) {
            if (array_key_exists($key, $request->all())) {
                $settingsToUpdate[$key] = is_bool($defaultValue)
                    ? $request->boolean($key)
                    : $request->input($key, $defaultValue);
            }
        }

        if ($settingsToUpdate !== []) {
            SiteSetting::setSettings($settingsToUpdate);
        }

        return back()->with('success', 'Homepage visibility settings updated.');
    }
}
