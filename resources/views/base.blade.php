<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>Seven</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="{{asset('css/materialize.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="{{asset('css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
	<script type="text/javascript">
		var API_BASE_URL = "{{url('/')}}" ;
	</script>

</head>
<body>
	<nav class="light-blue lighten-1" role="navigation">
		<div class="nav-wrapper container"><a id="logo-container" href="/data" class="brand-logo">Seven</a>

			<ul class="right hide-on-med-and-down">
				<li>
					@if(Session::has('user_name'))
    					<span style="background-color: white;padding: 10px;border-radius: 5px;color: blue;">Hi {{ Session::get('user_name')}}</span>
					@endif
				</li>
				<li>
					@if(Session::has('user_name'))
    					<a href="/logout">Logout</a>
					@endif
				</li>
				@if(Session::has('user_name'))
				<li onclick="getLocation()" id="viewbutton">
					View Restaurants
				</li>
				@endif
			</ul>

			<ul id="nav-mobile" class="side-nav">
				<li>
					@if(Session::has('user_name'))
    					{{ Session::get('user_name')}}
					@endif
				</li>
				<li onclick="cards()" id="viewbutton">
					View Restaurants
				</li>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
		</div>
	</nav>


	<div class="container">
		@yield('content')
	</div>
	<!--  Scripts-->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="js/materialize.js"></script>
	<script src="js/init.js"></script>
	@yield('scripts')
	</body>
</html>
