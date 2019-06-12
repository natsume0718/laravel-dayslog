<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/line-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.theme.css') }}">
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('css/nivo-lightbox.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
		integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>

<body>
	<header id="home" class="hero-area-2">
		<div class="overlay"></div>
		<nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar menu-bg">
			<div class="container">
				<a href="{{ url('/') }}" class="navbar-brand"><img src="{{ asset('img/logo.png', true) }}" alt="logo"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
					aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<i class="lni-menu"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto w-100 justify-content-end">
						@guest
						<li class="nav-item"><a class="nav-link page-scroll" href="{{ route('login') }}">Login</a></li>
						@else
						<li class="nav-item">
							<a class="nav-link page-scroll" href="{{ route('logout') }}"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>
	<!-- Header Section End -->
	@yield('header')
	</header>
	@yield('content')
	<!-- Footer Section Start -->
	<footer>
		<!-- Footer Area Start -->
		<section class="footer-Content">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
						<img src="{{ asset('img/logo.png', true) }}" alt="">
					</div>
				</div>
			</div>
			<!-- Copyright Start  -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="site-info float-left">
								<p>&copy; Natsume All Rights Reserved.</p>
							</div>
							<div class="float-right">
								<ul class="footer-social">
									<li><a class="twitter" href="https://twitter.com/natsume_aurlia"><i class="lni-twitter-filled fa-2x"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Copyright End -->
		</section>
		<!-- Footer area End -->
	</footer>
	<!-- Footer Section End -->

	<!-- Scripts -->
	<script src="{{ asset('js/jquery-min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.js') }}"></script>
	<script src="{{ asset('js/jquery.mixitup.js') }}"></script>
	<script src="{{ asset('js/jquery.nav.js') }}"></script>
	<script src="{{ asset('js/scrolling-nav.js') }}"></script>
	<script src="{{ asset('js/jquery.easing.min.js') }}"></script>
	<script src="{{ asset('js/wow.js') }}"></script>
	<script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
	<script src="{{ asset('js/nivo-lightbox.js') }}"></script>
	<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('js/waypoints.min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/count.js') }}"></script>
</body>

</html>