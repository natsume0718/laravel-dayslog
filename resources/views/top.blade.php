@extends('layouts.app')

@section('content')
<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-11 col-sm-offset-1">
				<h1>継続記録アプリ</h1>
				<img src="{{ asset('img/logo.png', true) }}" alt="logo" style="width:70vw">
				@guest
				<p><a class="btn btn-info" href="{{ route('login') }}"><i class="fab fa-twitter fa-lg" style="margin-right:0.8em"></i>Twitterで登録・ログイン</a></p>					
				@endguest
				@auth
				<p><a class="btn btn-info" href="{{ route('activity.index') }}"><i class="fas fa-pen fa-lg" style="margin-right:0.8em"></i>マイページへ</a></p>					
				@endauth
			</div>
		</div>
	</div>
</header>
@endsection