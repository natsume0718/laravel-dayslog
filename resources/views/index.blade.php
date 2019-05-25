@extends('layouts.app')

@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@foreach ($activities as $activity)
				<div class="panel panel-default">
					<div class="panel-heading">{{ $activity->name }}</div>
					<div class="panel-body">
							<li class="list-group-item">作成日:{{ $activity->created_at }}</li>
							<li class="list-group-item">
								<a class="btn btn-info" href="{{ route('activity.show',$activity->id) }}"
									role="button">記録する</a>
							</li>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<p class="btn btn-primary">
					<i class="fas fa-plus fa-lg"></i>
				</p>
				{!! Form::open(['route' => 'activity.store']) !!}
				<div class="form-group">
					{!! Form::label('name', '※タスク名：') !!}
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
	</div>
	</div>
</section>
@endsection