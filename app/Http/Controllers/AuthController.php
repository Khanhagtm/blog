<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use  App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirectToGitHub()
{
    return Socialite::driver('github')->redirect();
}

public function handleGitHubCallback()
{
    $user = Socialite::driver('github')->user();

    // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu hay chưa
    $existingUser = DB::table('users')->where('email', $user->email)->first();

    if ($existingUser) {
        // Người dùng đã tồn tại, đăng nhập
        Auth::loginUsingId($existingUser->id);
    } else {
        // Người dùng chưa tồn tại, tạo mới và đăng nhập
        $newUser = User::create([
            'name' => $user->nickname,
            'email' => $user->email,
            'provider' => 'github',
            'provider_id' => $user->id,
            'user_avatar' => $user->avatar,
            'role' => 'member',
        ]);

        Auth::login($newUser);
    }

    // Chuyển hướng đến trang sau khi đăng nhập thành công
    return redirect('/dashboard');
}

public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu hay chưa
    $existingUser = DB::table('users')->where('email', $user->email)->first();

    if ($existingUser) {
        // Người dùng đã tồn tại, đăng nhập
        Auth::loginUsingId($existingUser->id);
    } else {
        // Người dùng chưa tồn tại, tạo mới và đăng nhập
        $newUser = User::create([
            'name' => $user->nickname,
            'email' => $user->email,
            'provider' => 'google',
            'provider_id' => $user->id,
            'user_avatar' => $user->avatar,
            'role' => 'member',
        ]);

        Auth::login($newUser);
    }

    // Chuyển hướng đến trang sau khi đăng nhập thành công
    return redirect('/dashboard');
}


}