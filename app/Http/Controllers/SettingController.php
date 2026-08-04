<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * There is always exactly one settings row (id 1). Create it on the fly
     * if a migration ran without the seed step, so this never 500s.
     */
    protected function current(): Setting
    {
        return Setting::first() ?? Setting::create([
            'app_name' => config('app.name', 'AdminLTE'),
            'theme'    => 'light',
        ]);
    }

    public function edit()
    {
        $setting = $this->current();

        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = $this->current();

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:150'],
            'theme'    => ['required', 'string', 'in:light,dark'],
            'logo'     => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            // Remove the old logo file, if any, before storing the new one.
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $setting->update($validated);

        return back()->with('status', 'Settings saved successfully.');
    }
}