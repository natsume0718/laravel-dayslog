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
    </div>
</section>
@endsection