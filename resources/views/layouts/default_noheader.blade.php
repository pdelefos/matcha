<!DOCTYPE html>
<html>
<head>
	@include('includes.head', array('url', $url))
</head>
<body>
	<div class="container">
		@yield('content')
	</div>
</body>
</html>