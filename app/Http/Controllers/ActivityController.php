<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Twitter;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use Illuminate\Support\Facades\Session;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $twitter_user = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            $user->twitter_oauth_token,
            $user->twitter_oauth_token_secret
        );

        // 1131167887639498752
        $res = $twitter_user->get('statuses/retweeters/ids', ['id' => '1131167887639498752', 'cusor' => '1131167887639498852']);
        dd($res);
        $activities = Auth::user()->activities;
        return view('index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $user_activity = Auth::user()->activities()->create($request->all());
        return redirect()->back()->with('success', '新規追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return Auth::id() === $activity->user_id ?
            view('show', compact('activity')) :
            redirect()->route('top')->with('error', '不正なアクセスです');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function tweet(Request $request, Activity $activity)
    {
        $user = Auth::user();

        $twitter_user = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            $user->twitter_oauth_token,
            $user->twitter_oauth_token_secret
        );

        // 1131167887639498752
        $res = $twitter_user->get('statuses/retweeters/', ['id' => 327473909412814850]);
        dd($res);

        $res = $twitter_user->post("statuses/update", [
            "status" => $request->tweet
        ]);
        dd($res);

        return redirect()->back()->with('success', '投稿しました');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
