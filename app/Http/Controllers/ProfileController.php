<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $data['avatar'] = 'avatars/' . $avatarName;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show the landlord upgrade request form
     */
    public function showUpgradeForm(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            return redirect('/')->with('error', 'Tài khoản của bạn đã là chủ trọ hoặc quản trị viên.');
        }

        $pendingRequest = \App\Models\UpgradeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('profile.upgrade', compact('user', 'pendingRequest'));
    }

    /**
     * Store the upgrade request in database
     */
    public function storeUpgradeRequest(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            return redirect('/')->with('error', 'Hành động không hợp lệ.');
        }

        // Check if there is already a pending request
        $exists = \App\Models\UpgradeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Yêu cầu trước đó của bạn vẫn đang chờ xử lý.');
        }

        $request->validate([
            'full_name'            => 'required|string|max:255',
            'identity_number'      => 'required|string|regex:/^[0-9]{9,12}$/', // CCCD 12 số hoặc CMND 9 số
            'identity_date'        => 'required|date|before:today',
            'identity_place'       => 'required|string|max:255',
            'phone'                => 'required|string|max:15',
            'business_license'     => 'nullable|string|max:255',
            'property_name'        => 'required|string|max:255',
            'property_price'       => 'required|numeric|min:0',
            'property_acreage'     => 'required|integer|min:1',
            'property_city'        => 'required|string|max:255',
            'property_address'     => 'required|string|max:255',
            'property_description' => 'required|string',
            'property_photo'       => 'required|image|max:3072', // Bắt buộc tải ảnh căn phòng/giấy tờ
        ]);

        $photoPath = null;
        if ($request->hasFile('property_photo')) {
            $photoName = time() . '.' . $request->property_photo->extension();
            $request->property_photo->storeAs('products', $photoName, 'public');
            $photoPath = 'products/' . $photoName;
        }

        \App\Models\UpgradeRequest::create([
            'user_id'              => $user->id,
            'full_name'            => $request->full_name,
            'identity_number'      => $request->identity_number,
            'identity_date'        => $request->identity_date,
            'identity_place'       => $request->identity_place,
            'phone'                => $request->phone,
            'business_license'     => $request->business_license,
            'property_name'        => $request->property_name,
            'property_price'       => $request->property_price,
            'property_acreage'     => $request->property_acreage,
            'property_city'        => $request->property_city,
            'property_address'     => $request->property_address,
            'property_description' => $request->property_description,
            'property_photo'       => $photoPath,
            'status'               => 'pending',
        ]);

        return redirect()->route('profile.edit')->with('success', 'Yêu cầu nâng cấp tài khoản của bạn đã được gửi thành công! Ban quản trị sẽ thẩm định hồ sơ trong vòng 24 giờ làm việc.');
    }
}
