@extends('layouts.default_noheader', array('url', $url))
@section('content')
	<div class='home-wrap'>
		<a href="#" class="home-connection-link">se connecter</a>
		<div class="home-container">
			<div class="home-pres">
				<h2 class="home-pres__title">Matcha</h2>
				<div class="home-pres__info">
					Site de rencontre cool.
				</div>
			</div>
			<div class="home-register">
				<h2 class="home-register__title">Inscription</h2>
				<form action="#" method="post" class="form-register">
				<input class="form-register__input" type="text" name="email" placeholder="EMAIL">
				<input class="form-register__input" type="text" name="login" placeholder="PSEUDO">
				<input class="form-register__input" type="text" name="prenom" placeholder="PRENOM">
				<input class="form-register__input" type="text" name="nom" placeholder="NOM">
				<input class="form-register__input" type="text" name="password" placeholder="MOT DE PASSE">
				<input class="form-register__input btn-submit" type="submit" name="submit" value="Je m'inscris">
			</form>
			</div>
		<div>
	</div>
@stop