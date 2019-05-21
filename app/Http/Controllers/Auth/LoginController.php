<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Socialite;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * ユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $twitter_user = null;
        //情報取得
        try {
            $twitter_user = Socialite::driver('twitter')->user();
            // dd($twitter_user);
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
        if ($twitter_user) {
            $user = User::firstOrCreate($twitter_user->id);
        }
        // $user->token;
    }
}