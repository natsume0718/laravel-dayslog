@extends('layouts.app')

@section('content')
<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-11 col-sm-offset-1">
				<h1>継続記録アプリ</h1>
				<img src="{{ asset('img/logo.png', true) }}" alt="logo" style="width:70vw">
				<p><a href="{{ route('login') }}">Twitterで登録・ログイン</a></p>
			</div>
		</div>
	</div>
</header>
@endsection