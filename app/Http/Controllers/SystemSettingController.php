<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingRequest;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    // Daftar semua setting
    public function index()
    {
        $systemSettings = SystemSetting::paginate(10);
        return view('pages.system_settings.index', compact('systemSettings'));
    }

    // Form tambah setting
    public function create()
    {
        return view('pages.system_settings.create');
    }

    // Simpan setting baru
    public function store(SystemSettingRequest $request)
    {
        $data = $request->validated();
        $setting = SystemSetting::create($data);

        // Jika setting adalah warna, regenerasi CSS tema
        if (str_contains($setting->key, '_color')) {
            app(ThemeController::class)->generateCSS();
        }

        return redirect()->route('system-settings.show', $setting)->with('success', 'Pengaturan berhasil ditambah.');
    }

    // Detail setting
    public function show(SystemSetting $systemSetting)
    {
        return view('pages.system_settings.show', compact('systemSetting'));
    }

    // Form edit
    public function edit(SystemSetting $systemSetting)
    {
        return view('pages.system_settings.edit', compact('systemSetting'));
    }

    // Update setting
    public function update(SystemSettingRequest $request, SystemSetting $systemSetting)
    {
        $data = $request->validated();
        $systemSetting->update($data);

        // Jika setting adalah warna, regenerasi CSS tema
        if (str_contains($systemSetting->key, '_color')) {
            app(ThemeController::class)->generateCSS();
        }

        return redirect()->route('system-settings.show', $systemSetting)->with('success', 'Pengaturan berhasil diupdate.');
    }

    // Hapus (softdelete, jika model pakai SoftDeletes)
    public function destroy(SystemSetting $systemSetting)
    {
        $systemSetting->delete();
        return redirect()->route('system-settings.index')->with('success', 'Pengaturan berhasil dihapus.');
    }
}
