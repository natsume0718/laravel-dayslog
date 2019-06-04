@extends('layouts.app')

@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<ul class="list-group">
					<li class="list-group-item">合計時間：{{ $activity->hour }} 時間</li>
					<li class="list-group-item">継続日数：{{ $activity->continuation_days }} 日</li>
				</ul>
				{!! Form::open(['method' => 'PATCH','route' =>
				['activity.tweet',$user->twitter_nickname,$activity->task_id]]) !!}
				<div class="form-group">
					{!! Form::label('hour', '活動時間：') !!}
					{!! Form::select('hour', $time,old('hour'), ['class' => 'form-control','min'=>'0']) !!}
					@if ($errors->has('hour'))
					<span style="color:red;">
						{{ $errors->first('hour') }}
					</span>
					@endif
				</div>
				<div class="form-group">
					{!! Form::label('tweet', '※活動内容をTwitterに投稿：') !!}
					{!! Form::textarea('tweet', old('name'), ['class' => 'form-control']) !!}
					@if ($errors->has('tweet'))
					<span style="color:red;">
						{{ $errors->first('tweet') }}
					</span>
					@endif
				</div>
				<div class="form-group">
					{!! Form::label('is_reply', '※リプライ形式で投稿：') !!}
					{!! Form::checkbox('is_reply', old('is_reply'), ['class' => 'form-control']) !!}
					@if ($errors->has('is_reply'))
					<span style="color:red;">
						{{ $errors->first('is_reply') }}
					</span>
					@endif
				</div>
				<div style="display:flex;justify-content: space-between;">
					{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
					<a class="btn btn-info" href="{{ route('activity.index',$user->twitter_nickname) }}"><i
							class="fas fa-pen fa-lg" style="margin-right:0.8em"></i>マイページへ</a>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="col" style="height:40vh; overflow: scroll; margin-top:1em;">
					@isset($tweets)
					<table class="table table-stiped table-bordered" style="background-color:white;">
						<tr>
							<th>ユーザー</th>
							<th>活動内容</th>
							<th>投稿時刻</th>
							<th>活動時間</th>
							<th></th>
							<th></th>
						</tr>
						@foreach ($tweets as $tweet)
						<tr>
							<td><img src="{{ $user->twitter_avatar }}" alt=""><span>{{ $user->twitter_name }}</span>
							</td>
							<td>{!! nl2br(e($tweet->body)) !!}</td>
							<td>{{ $tweet->created_at }}</td>
							<td>{{ $tweet->hour }} 時間</td>
							<td>
								<a target="_blank"
									href="https://twitter.com/{{$user->twitter_nickname}}/status/{{$tweet->tweet_id}}">Twitterで表示</a>
							</td>
							<td>
								{!! Form::open(['method' => 'DELETE','route' =>['tweet.delete',$user->twitter_nickname,$activity->task_id,$tweet->tweet_id], 'class'=>'d-inline'])!!}
								{!! Form::submit('削除', ['class'=>'btn btn-danger']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
						@endforeach
					</table>
					@endisset
				</div>
			</div>
		</div>
	</div>
</section>
@endsection