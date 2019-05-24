<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Session;
use Abraham\TwitterOAuth\TwitterOAuth;



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
        $twitter = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret')
        );
        # 認証用のrequest_tokenを取得
        # このとき認証後、遷移する画面のURLを渡す
        $token = $twitter->oauth('oauth/request_token', array(
            'oauth_callback' => config('twitter.callback_url')
        ));

        # 認証画面で認証を行うためSessionに入れる
        session(array(
            'oauth_token' => $token['oauth_token'],
            'oauth_token_secret' => $token['oauth_token_secret'],
        ));

        # 認証画面へ移動させる
        ## 毎回認証をさせたい場合： 'oauth/authorize'
        ## 再認証が不要な場合： 'oauth/authenticate'
        $url = $twitter->url('oauth/authenticate', array(
            'oauth_token' => $token['oauth_token']
        ));

        return redirect($url);
        // return Socialite::driver('twitter')->redirect();
    }

    /**
     * ユーザーのアクセストークンを取得する
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $oauth_token = session('oauth_token');
        $oauth_token_secret = session('oauth_token_secret');

        # request_tokenが不正な値だった場合エラー
        if ($request->has('oauth_token') && $oauth_token !== $request->oauth_token) {
            return redirect()->route('top')->with('error', '不正な操作が行われました');
        }

        try {
            # request_tokenからaccess_tokenを取得
            $twitter = new TwitterOAuth(
                $oauth_token,
                $oauth_token_secret
            );

            $token = $twitter->oauth('oauth/access_token', array(
                'oauth_verifier' => $request->oauth_verifier,
                'oauth_token' => $request->oauth_token,
            ));

            # access_tokenを用いればユーザー情報へアクセスできるため、それを用いてTwitterOAuthをinstance化
            $twitter_user = new TwitterOAuth(
                config('twitter.consumer_key'),
                config('twitter.consumer_secret'),
                $token['oauth_token'],
                $token['oauth_token_secret']
            );

            # 本来はアカウント有効状態を確認するためのものですが、プロフィール取得にも使用可能
            $twitter_user_info = $twitter_user->get('account/verify_credentials');
            // dd($twitter_user_info);

        } catch (Exception $e) {
            return redirect()->route('top')->with('error', 'Twitterアカウント取得に失敗しました');
        }

        if ($twitter_user_info) {
            //ユーザーの取得または生成
            $user = User::firstOrCreate(['twitter_id' => $twitter_user_info->id]);
            //最新状態に更新
            $user->update(
                [
                    'twitter_name' => $twitter_user_info->name,
                    'twitter_nickname' => $twitter_user_info->screen_name,
                    'twitter_avatar_original' => $twitter_user_info->profile_image_url,
                    'twitter_oauth_token' => $token['oauth_token'],
                    'twitter_oauth_token_secret' => $token['oauth_token_secret']
                ]
            );
            Auth::login($user, true);
            return redirect()->route('activity.index')->with('success', 'ログインしました');
        }
        return redirect()->route('top')->with('erorr', 'エラーが発生しました。再度お試しください');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('top')->with('success', 'ログアウトしました');
    }
}