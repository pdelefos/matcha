<!DOCTYPE html>
<html>
<head>
	@include('includes.head', array('url', $url))
</head>
<body class="home-background">
	<div class="container">
		@yield('content')
	</div>
	<script type="text/javascript" src="{{ $url }}/js/waveText.js"></script>
</body>
</html>