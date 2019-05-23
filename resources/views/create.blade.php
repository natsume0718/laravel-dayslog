@extends('layouts.app')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::open(['route' => 'store']) !!}
                <div class="form-group">
                    {!! Form::label('name', '※タスク名：') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                    <span style="color:red;">
                        {{ $errors->first('name') }}
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