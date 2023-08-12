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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function UploadImage(Request $request)
    {
        $path = $request->file('fileToUpload')->store('avatars');
        $user = $request->user();
        $user->user_avatar = $path;
        $user->save();
        return back();

        /*$data = $request->input('image');
        $photo = $request->file('image')->getClientOriginalName();
        $destination = base_path() . '/public/uploads';
        $request->file('image')->move($destination, $photo);
        dd( $photo );*/

        /*dd( $request->all());
        $file_name = $request->getClientoriginalName();
        dd( $file_name );
        $file->move(public_path('uploads'),file_name);*/

    }
}
