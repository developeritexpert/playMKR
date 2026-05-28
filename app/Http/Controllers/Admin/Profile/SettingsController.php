<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileSetting\UpdatePasswordRequest;
use App\Http\Requests\ProfileSetting\UpdateProfileRequest;
use App\Services\Admin\Profile\SettingsService;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    protected SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function show()
    {
        return $this->settingsService->getProfile(Auth::user());
    }

    public function update(UpdateProfileRequest $request)
    {
        return $this->settingsService->updateProfile(Auth::user(), $request->validated());
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->settingsService->updatePassword(Auth::user(), $request->validated());
    }
}
