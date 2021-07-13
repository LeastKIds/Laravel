<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        dd($user);


    }
}
