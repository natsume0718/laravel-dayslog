<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Error</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
		integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<!-- Custom stlylesheet -->
	<link rel="stylesheet" href="{{ asset('css/errorstyle.css') }}">

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h3>ご不便をおかけして申し訳ございません。</h3>
				<h1><span>{{$status_code}}</span></h1>
			</div>
			<h2>{{ $message }}</h2>
			<div id="report">
			<a class="twitter" href="https://twitter.com/natsume_aurlia"><i class="fab fa-twitter">問題を報告する</i></a>
			</div>
		</div>
	</div>
</body>

</html>
