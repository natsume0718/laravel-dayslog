@extends('layouts.app')

@section('content')
<section>
@include('layouts.message')
<div id="app-features" class="section">
		<div class="container">
			<div class="section-header">
				<p class="btn btn-subtitle">
					activity</p>
				<h2 class="section-title wow fadeIn animated" data-wow-delay="0.2s"
					style="visibility: visible;-webkit-animation-delay: 0.2s; -moz-animation-delay: 0.2s; animation-delay: 0.2s;">
					活動一覧</h2>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-12 col-xs-12"></div>
				<div class="col-lg-4 col-md-12 col-xs-12">
					<div class="show-box">
						@foreach ($activities as $activity)
						<div class="panel panel-default">
							<div class="panel-heading">{{ $activity->name }}</div>
							<div class="panel-body">
								<li class="list-group-item">作成日:{{ $activity->created_at }}</li>
								<li class="list-group-item">
									<a class="btn btn-info"
										href="{{ route('activity.show',[$user->twitter_nickname ,$activity->task_id]) }}"
										role="button" style="margin-bottom:0.8em">記録する</a>
								</li>
								<li class="list-group-item">
									{!! Form::open(['method' => 'DELETE','route'
									=>['activity.delete',$user->twitter_nickname,$activity->task_id],
									'class'=>'d-inline'])
									!!}
									{!! Form::submit('削除', ['class'=>'btn btn-danger']) !!}
									{!! Form::close() !!}
								</li>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="col-lg-4 col-md-12 col-xs-12"></div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-12 col-xs-12"></div>
				<div class="col-lg-4 col-md-12 col-xs-12">
					<div class="show-box">
						{!! Form::open(['route' => ['activity.store',$user->twitter_nickname]]) !!}
						<div class="form-group">
							{!! Form::label('name', '※継続したい活動名：') !!}
							{!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
							@if ($errors->has('name'))
							<p>
								<span style="color:red;">
									{{ $errors->first('name') }}
								</span </p> @endif <p>
								{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
							</p>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
				<div class="col-lg-4 col-md-12 col-xs-12"></div>
			</div>
		</div>
	</div>
</section>
@endsection