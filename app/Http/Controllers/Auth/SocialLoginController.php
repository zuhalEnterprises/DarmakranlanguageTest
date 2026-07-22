<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // جستجو بر اساس username (که اینجا همون ایمیل هست)
        $user = User::where('username', $googleUser->getEmail())->first();

        if ($user) {
            // به‌روزرسانی اطلاعات کاربر
            $user->update([
                'name' => $googleUser->getName(),
                'photo' => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(),
            ]);
        } else {
            // ایجاد کاربر جدید
            $user = User::create([
                'name' => $googleUser->getName(),
                'photo' => $googleUser->getAvatar(),
                'username' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(uniqid()), // رمز تصادفی
            ]);
        }

        // ورود کاربر
        Auth::login($user);

        return redirect('/');
    } catch (\Exception $e) {
        return redirect('/login')->withErrors(['msg' => 'ورود با گوگل ناموفق بود.']);
    }
}


}
