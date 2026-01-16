<?php

namespace App\Http\Controllers\Backend;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{

    public function index()
    {
        $profile = Profile::first();
        return view('backend.profile.index', compact('profile'));
    }


    public function update(UpdateProfileRequest $request)
    {
        $profile = Profile::first();
        $profile->update($request->all());

        if ($request->hasFile('image')) {
            $profile
                ->addMedia($request->image)
                ->toMediaCollection('image');
        }

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data has been updated successfully"
        ]);
        return redirect()->back();
    }
}
