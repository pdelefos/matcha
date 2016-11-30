<!DOCTYPE html>
<html>
<head>
	@include('includes.head')
</head>
<body>
	<div class="container">
		<header class="navbar">
			@include('includes.header')
		</header>
		@yield('content')
	</div>
</body>
</html>