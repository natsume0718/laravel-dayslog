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

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
        if ($twitter_user) {
            //ユーザーの取得または生成
            $user = User::firstOrCreate(
                ['twitter_id' => $twitter_user->id],
                [
                    'twitter_name' => $twitter_user->name,
                    'twitter_nickname' => $twitter_user->nickname,
                    'twitter_avatar_original' => $twitter_user->avatar_original
                ]
            );
            Auth::login($user, true);
        }
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}