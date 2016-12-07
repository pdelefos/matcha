<!DOCTYPE html>
<html>
<head>
	@include('includes.head', array('url_app', $page_need['url_app']))
</head>
<body class="register-background">
	<div class="container">
		@yield('content')
	</div>
	<script type="text/javascript" src="{{ $page_need['url_app'] }}/js/waveText.js"></script>
</body>
</html>