<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use Abraham\TwitterOAuth\TwitterOAuth;
use Socialite;
use Exception;
use Illuminate\Support\Facades\Log;


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
     * ユーザーのアクセストークンを取得する
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {

        try {

            $twitter_user = Socialite::driver('twitter')->user();  
            //アクセストークン取得
            $token = $twitter_user->token;
            $token_secret = $twitter_user->tokenSecret;
            if (!$twitter_user || !$token || !$token_secret)
                throw new \RuntimeException('ユーザー取得の失敗');

           
            //ユーザーの取得または生成
            $user = User::firstOrCreate(['twitter_id' => $twitter_user->id]);
            //最新状態に更新
            $update_result = $user->update(
                [
                    'twitter_name' => $twitter_user->name,
                    'twitter_nickname' => $twitter_user->nickname,
                    'twitter_avatar' => $twitter_user->user['profile_image_url_https'],
                    'twitter_oauth_token' => $token,
                    'twitter_oauth_token_secret' => $token_secret
                ]
            );

            if (!$user || !$update_result)
                throw new \RuntimeException('ユーザー情報の生成または更新の失敗');

            Auth::login($user, true);
            return redirect()->route('activity.index', $twitter_user->nickname)->with('success', 'ログインしました');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('top')->with('error', 'Twitterアカウント取得に失敗しました');
        }

        return redirect()->route('top')->with('erorr', 'エラーが発生しました。再度お試しください');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('top')->with('success', 'ログアウトしました');
    }
}