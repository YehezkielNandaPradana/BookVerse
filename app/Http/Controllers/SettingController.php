<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan umum perpustakaan.
     */
    public function edit()
    {
        $setting = Setting::firstOrCreate([]);

        return view('settings.edit', compact('setting'));
    }

    /**
     * Update pengaturan: nama, logo, favicon, lama pinjam, maksimal buku, denda/hari.
     */
    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([]);

        $validated = $request->validate([
            'library_name'    => 'required|string|max:150',
            'logo'            => 'nullable|image|max:1024',
            'favicon'         => 'nullable|image|max:512',
            'borrow_limit'    => 'required|integer|min:1',
            'borrow_duration' => 'required|integer|min:1',
            'fine_per_day'    => 'required|numeric|min:0',
            'address'         => 'nullable|string',
            'phone'           => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:150',
        ]);

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $setting->update($validated);

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Daftar pengumuman.
     */
    public function announcements()
    {
        $announcements = Announcement::orderByDesc('published_at')->paginate(10);

        return view('settings.announcements.index', compact('announcements'));
    }

    public function createAnnouncement()
    {
        return view('settings.announcements.create');
    }

    /**
     * Simpan pengumuman baru.
     */
    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:200',
            'content'      => 'required|string',
            'published_at' => 'required|date',
            'expired_at'   => 'nullable|date|after:published_at',
        ]);

        Announcement::create($validated);

        return redirect()->route('settings.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function editAnnouncement(Announcement $announcement)
    {
        return view('settings.announcements.edit', compact('announcement'));
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:200',
            'content'      => 'required|string',
            'published_at' => 'required|date',
            'expired_at'   => 'nullable|date|after:published_at',
        ]);

        $announcement->update($validated);

        return redirect()->route('settings.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
