<!DOCTYPE html>
<html lang="en">

<head>
	<title>@yield('title') | Sistem Informasi Pemantauan Obat</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('template/assets/images/APOTECH1.png')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/vendor/bootstrap/css/bootstrap.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"
		href="{{asset('template_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"
		href="{{asset('template_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/vendor/animate/animate.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/vendor/animsition/css/animsition.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/vendor/select2/select2.min.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"
		href="{{asset('template_login/vendor/daterangepicker/daterangepicker.css')}}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('template_login/css/main.css')}}">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		
		<div class="container-login100">
			@yield('main')
		</div>
	</div>





	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/animsition/js/animsition.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('template_login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/select2/select2.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('template_login/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/vendor/countdowntime/countdowntime.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('template_login/js/main.js')}}"></script>

</body>

</html>