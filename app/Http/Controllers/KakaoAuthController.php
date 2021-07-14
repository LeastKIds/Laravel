<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class KakaoAuthController extends Controller
{

//      curl -v -X POST "https://kapi.kakao.com/v1/user/unlink"
//      -H "Authorization: KakaoAK {6b8822b1870ed966e288d253d046d54f}”
//      -d "target_id_type= user_id"
//      -d "target_id= 1716843814"
//      카카오톡 아이디 연결 해제


    public function __construct()
    {
        $this -> middleware(['guest']);
    }

    public function redirect() {
        return Socialite::driver('kakao')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('kakao')->user();

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
