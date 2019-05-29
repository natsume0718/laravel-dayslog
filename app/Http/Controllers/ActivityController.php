<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Twitter;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use Illuminate\Support\Facades\Session;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
		$activities = Auth::user()->activities;
		return view('index', compact('user', 'activities'));
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
		//task作成
		DB::transaction(function () use ($request) {
			$user = Auth::user();
			$task_max = $user->activities->max('task_id') + 1;
			$user_activity = $user->activities()->create($request->all());
			$user_activity->update(['task_id' => $task_max]);
		});

		return redirect()->back()->with('success', '新規追加しました');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param string $user_name
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(String $user_name, Activity $activity)
	{
		if (Auth::id() != $activity->user_id)
			return redirect()->route('top')->with('error', '不正なリクエストです');

		$user = Auth::user();

		//ツイート取得
		$tweets = $activity->tweets;

		return view('show', compact('activity', 'user', 'tweets'));

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

	public function tweet(String $user_name, Request $request, Activity $activity)
	{
		if (Auth::id() != $activity->user_id)
			return redirect()->route('top')->with('error', '不正なリクエストです');
		
		//バリデーション
		$request->validate(['tweet' => 'required|max:140|unique:tweets,body']);

		$user = Auth::user();

		$twitter_user = new TwitterOAuth(
			config('twitter.consumer_key'),
			config('twitter.consumer_secret'),
			$user->twitter_oauth_token,
			$user->twitter_oauth_token_secret
		);
		//最新のツイートID取得
		$latest_tweet = $request->is_reply ? $activity->tweets()->latest()->first(['tweet_id']) : null;
		//投稿
		$tweet = $twitter_user->post("statuses/update", [
			"status" => $request->tweet,
			'in_reply_to_status_id' => $latest_tweet->tweet_id ?? null
		]);

		//ツイートを保存
		if ($tweet->id) {
			$activity->tweets()->create([
				'user_id' => $user->twitter_id,
				'tweet_id' => $tweet->id,
				'body' => $tweet->text,
			]);
		}

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
	public function destroy(String $user_name, Activity $activity)
	{
		if (Auth::id() != $activity->user_id)
			return redirect()->route('top')->with('error', '不正なリクエストです');
		$activity->delete();
		return redirect()->back()->with('success', '活動を削除しました');
	}
}
