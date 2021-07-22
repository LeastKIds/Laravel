<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    //

    public function __construct()
    {
        $this -> middleware(['guest']);
    }

    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $user -> getEmail()],
            ['password' => Hash::make(Str::random(24)),
                'name' => $user -> getName()]
        );

        // 로그인 처리...
        Auth::login($user);

        // 사용자가 원래 요청했던 페이지로 redirection
        // 원래 요청했던 페이지가 없으면 /dashboard로 redirection
        return redirect() -> intended('/dashboard');

    }
}
