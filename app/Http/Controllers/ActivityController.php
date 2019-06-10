<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Twitter;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Rules\InputHour;
use Carbon\Carbon;

class ActivityController extends Controller
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
		$activities = $user->activities;
		return view('index', compact('user', 'activities'));
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
		$user = Auth::user();
		$time = Config::get('form_input_settings.time', array());
		//ツイート取得
		$tweets = $activity->tweets()->latest()->get();
		$latest_tweet = $tweets->first();
		return view('show', compact('activity', 'user', 'tweets', 'time', 'latest_tweet'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(String $user_name, Request $request, Activity $activity)
	{
		//バリデーション
		$request->validate(
			[
				'tweet' => ['required'],
				'hour' => ['required', 'numeric', new InputHour]
			]
		);

		$user = Auth::user();

		// //最新のツイートID取得してツイート
		$latest_tweet = $request->is_reply ? $activity->tweets()->latest()->first(['tweet_id']) : null;
		$tweet = $this->twitterTweet($request->tweet, $latest_tweet->tweet_id ?? null);
		
		//ツイート成功時DBに保存
		if ($tweet) {
			//活動時間取得
			$time = Config::get('form_input_settings.time', array());
			$hour = $time[$request->hour];
			//投稿を保存
			$posted_tweet = $activity->tweets()->create([
				'user_id' => $user->twitter_id,
				'tweet_id' => $tweet->id,
				'body' => $tweet->text,
				'hour' => $hour
			]);
			if ($posted_tweet && $hour) {
				//活動時間のある、今日より以前の最新のツイート取得
				$exist_hour_latest_tweet = $activity->tweets()->where('created_at', '<', new Carbon('today', 'Asia/Tokyo'))->where('hour', '>', 0)->latest()->first();
				//差分取得
				$diff_posted_day = $exist_hour_latest_tweet ? $exist_hour_latest_tweet->created_at->diffInDays($posted_tweet->created_at) : null;
				//前日に投稿しているなら継続日数+1
				if ($exist_hour_latest_tweet && $exist_hour_latest_tweet->created_at->isYesterDay()) {
					$activity->increment('continuation_days', 1);
				}
				//２日以上経過していたら、継続日数リセット
				if ($diff_posted_day && $diff_posted_day > 1) {
					$activity->update(['continuation_days' => 0]);
				}
				$activity->increment('hour', $hour);
			}
			return redirect()->back()->with('success', '投稿しました');
		}
		return redirect()->back()->with('error', '投稿に失敗しました')->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Activity $activity
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(String $user_name, Activity $activity)
	{
		$activity->delete();
		return redirect()->back()->with('success', '活動を削除しました');
	}


	/**
	 * ツイートの削除をする
	 * 
	 * @param  String $user_name
	 * @param  Activity $activity
	 * @param  String $id
	 * @return \Illuminate\Http\Response
	 */
	public function deleteTweet(String $user_name, Activity $activity, String $id)
	{
		$user = $activity->user;
		$db_tweet = $activity->tweets()->where('tweet_id', $id)->first();
		if ($db_tweet) {
			$hour = $db_tweet->hour;
			$db_tweet->delete();
			$activity->decrement('hour', $hour);
			$twitter_user = new TwitterOAuth(
				config('twitter.consumer_key'),
				config('twitter.consumer_secret'),
				$user->twitter_oauth_token,
				$user->twitter_oauth_token_secret
			);
			//削除
			$tweet = $twitter_user->post("statuses/destroy", [
				"id" => $id,
			]);
			return redirect()->back()->with(isset($tweet->errors) ? 'error' : 'success', isset($tweet->errors) ? '削除に失敗しました' : '削除しました');
		}


	}

	/**
	 * ツイッターにてツイートを行う
	 *
	 * @param  String  $txt
	 * @param  String  $replyTo
	 * @return null | array
	 */
	private function twitterTweet(String $txt, String $replyId = null)
	{
		$user = Auth::user();

		$twitter_user = new TwitterOAuth(
			config('twitter.consumer_key'),
			config('twitter.consumer_secret'),
			$user->twitter_oauth_token,
			$user->twitter_oauth_token_secret
		);
		//投稿
		$tweet = $twitter_user->post("statuses/update", [
			"status" => $txt,
			'in_reply_to_status_id' => $replyId,
		]);

		//エラー出たらnullを返す
		return isset($tweet->errors) ? null : $tweet;

	}
}
