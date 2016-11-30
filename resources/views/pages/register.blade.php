<?php
$page_need = array(
	'url_app' => route('root')
);
if (isset($errorHandler)) {
	$error_nom = $errorHandler->first('nom');
	$error_prenom = $errorHandler->first('prenom');
	$error_email = $errorHandler->first('email');
	$error_login = $errorHandler->first('login');
	$error_password = $errorHandler->first('password');
}
if (isset($prev_values)) {
	$prev_nom = $prev_values->input('nom');
	$prev_prenom = $prev_values->input('prenom');
	$prev_email = $prev_values->input('email');
	$prev_login = $prev_values->input('login');
}
?>
@extends('layouts.default_noheader', $page_need)
@section('content')
<div class='home-wrap'>
	<a href="{{ $page_need['url_app'] }}/connexion" class="home-connection-link btn-connection btn-hover">se connecter</a>
	<div class="home-container">
		<div class="home-pres">
			<h2 class="home-pres__title">
				<div class="wavetext"></div>
			</h2>
			<div class="home-pres__info">
				Site de rencontre à la cool.
			</div>
		</div>
		<div class="home-register">
			<h2 class="form__title">INSCRIPTION</h2>
			<form action="#" method="post" class="form-register">
			@if (isset($error_nom) && $error_nom != "")
				<div class="home-register__error" data-error="{{ $error_nom }}" >
			@else
				<div>
			@endif
				<input class="form-register__input" type="text" name="nom" placeholder="NOM" value="{{ $prev_nom or '' }}">
			</div>
			@if (isset($error_prenom) && $error_prenom != "")
				<div class="home-register__error" data-error="{{ $error_prenom }}">
			@else
				<div>
			@endif
				<input class="form-register__input" type="text" name="prenom" placeholder="PRENOM" value="{{ $prev_prenom or '' }}">
			</div>
			@if (isset($error_email) && $error_email != "")
				<div class="home-register__error" data-error="{{ $error_email }}">
			@else
				<div>
			@endif
				<input class="form-register__input" type="text" name="email" placeholder="EMAIL" value="{{ $prev_email or '' }}">
			</div>
			@if (isset($error_login) && $error_login != "")
				<div class="home-register__error" data-error="{{ $error_login }}">
			@else
				<div>
			@endif
				<input class="form-register__input" type="text" name="login" placeholder="PSEUDO" value="{{ $prev_login or '' }}">
			</div>
			@if (isset($error_password) && $error_password != "")
				<div class="home-register__error" data-error="{{ $error_password }}">
			@else
				<div>
			@endif
				<input class="form-register__input" type="text" name="password" placeholder="MOT DE PASSE">
			</div>
			<input class="form-register__input btn-submit btn-hover" type="submit" name="submit" value="Je m'inscris">
		</form>
		</div>
	<div>
</div>
@stop