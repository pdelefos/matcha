<!DOCTYPE html>
<html>
<head>
	@include('includes.head', array('title' => 'mdr'))
</head>
<body>
	<div class="container">
		<header>
			@include('includes.header')
		</header>
		@yield('content')
	</div>
</body>
</html>