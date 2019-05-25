@extends('layouts.app')

@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::open(['route' => ['activity.tweet',$activity->id]]) !!}
				<div class="form-group">
					{!! Form::label('tweet', '※つぶやく：') !!}
					{!! Form::textarea('tweet', old('name'), ['class' => 'form-control']) !!}
					@if ($errors->has('tweet'))
					<span style="color:red;">
						{{ $errors->first('tweet') }}
					</span>
					@endif
					{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="col" style="height:40vh; overflow: scroll;">
					@isset($tweets)
					<table class="table table-stiped table-bordered" style="background-color:white;">
						@foreach ($tweets as $tweet)
						<tr>
							<td><img src="{{ $user->twitter_avatar }}" alt=""><span>{{ $user->twitter_name }}</span></td>
							<td>{!! nl2br(e($tweet->body)) !!}</td>
							<td><a href="https://twitter.com/{{$user->twitter_nickname}}/status/{{$tweet->tweet_id}}">Twitterで表示</a></td>
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