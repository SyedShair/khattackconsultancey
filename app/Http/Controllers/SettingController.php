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

        $days = array_keys(Setting::DAYS);

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:150'],
            'theme'    => ['required', 'string', 'in:light,dark'],
            'logo'     => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],

            'address'  => ['nullable', 'string', 'max:500'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'email'    => ['nullable', 'email', 'max:150'],
            'map_url'  => ['nullable', 'url', 'max:1000'],

            'opening_hours'                 => ['required', 'array'],
            'opening_hours.*.closed'        => ['nullable', 'boolean'],
            'opening_hours.*.open'          => ['nullable', 'required_if:opening_hours.*.closed,0', 'date_format:H:i'],
            'opening_hours.*.close'         => ['nullable', 'required_if:opening_hours.*.closed,0', 'date_format:H:i', 'after:opening_hours.*.open'],
        ]);

        if ($request->hasFile('logo')) {
            // Remove the old logo file, if any, before storing the new one.
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Normalize opening hours: only keep known days, coerce "closed"
        // checkbox to a real boolean, and null out times when closed.
        $openingHours = [];
        foreach ($days as $day) {
            $row = $request->input("opening_hours.$day", []);
            $closed = $request->boolean("opening_hours.$day.closed");

            $openingHours[$day] = [
                'open'   => $closed ? null : ($row['open'] ?? null),
                'close'  => $closed ? null : ($row['close'] ?? null),
                'closed' => $closed,
            ];
        }
        $validated['opening_hours'] = $openingHours;

        $setting->update($validated);

        return back()->with('status', 'Settings saved successfully.');
    }
}