<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ✅ Hiển thị trang quản lý settings
    public function settings()
    {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }

    // ✅ Cập nhật ảnh
    public function updateSetting(Request $request, $key)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => 'storage/' . $path]
            );
        }

        return back()->with('success', 'Cập nhật ảnh thành công!');
    }
}