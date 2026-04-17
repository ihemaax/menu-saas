<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingsController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;

        if (!$tenant) {
            return view('settings.create');
        }

        return view('settings.edit', compact('tenant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'slug' => 'required|string|unique:tenants,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_open' => 'boolean',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $tenant = Tenant::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'slug' => $request->slug,
            'description' => $request->description,
            'logo' => $logoPath,
            'is_open' => $request->boolean('is_open', true),
        ]);

        auth()->user()->update(['tenant_id' => $tenant->id]);

        return redirect()->route('dashboard')->with('success', 'Settings saved successfully.');
    }

    public function update(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'slug' => 'required|string|unique:tenants,slug,' . $tenant->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_open' => 'boolean',
        ]);

        $logoPath = $tenant->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $tenant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'slug' => $request->slug,
            'description' => $request->description,
            'logo' => $logoPath,
            'is_open' => $request->boolean('is_open', $tenant->is_open),
        ]);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }

    public function generateQrCode()
    {
        $tenant = auth()->user()->tenant;
        $url = route('menu.show', $tenant->slug);

        return QrCode::size(300)->format('png')->generate($url);
    }
}