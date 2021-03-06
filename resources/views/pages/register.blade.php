<?php
$page_need = array(
	'url_app' => route('root'),
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
<div class='flex-container'>
	<a href="{{ $page_need['url_app'] }}/connexion" class="connection-link link-btn">se connecter</a>
	<div class="welcome-container">
		<div class="welcome-pres">
			<h2 class="welcome-pres__title logo">
				<div class="wavetext"></div>
			</h2>
			<div class="welcome-pres__info">
				Site de rencontre à la cool
			</div>
		</div>
		<div class="welcome-register form__box">
			<h2 class="form__title">INSCRIPTION</h2>
			<form action="#" method="post" class="form-register">
				<div class="form-row">
					<label class="form-label">Mon nom</label>
					@if (isset($error_nom) && $error_nom != "")
						<div class="form__error" data-error="{{ $error_nom }}" >
					@else
						<div>
					@endif
							<input class="form__input" type="text" name="nom" value="{{ $prev_nom or '' }}">
						</div>
				</div>
				<div class="form-row">
					<label class="form-label">Mon prénom</label>
					@if (isset($error_prenom) && $error_prenom != "")
						<div class="form__error" data-error="{{ $error_prenom }}">
					@else
						<div>
					@endif
							<input class="form__input" type="text" name="prenom" value="{{ $prev_prenom or '' }}">
						</div>
				</div>
				<div class="form-row">
					<label class="form-label">Mon email</label>
					@if (isset($error_email) && $error_email != "")
						<div class="form__error" data-error="{{ $error_email }}">
					@else
						<div>
					@endif
							<input class="form__input" type="text" name="email" value="{{ $prev_email or '' }}">
						</div>
				</div>
				<div class="form-row">
					<label class="form-label">Mon login</label>
					@if (isset($error_login) && $error_login != "")
						<div class="form__error" data-error="{{ $error_login }}">
					@else
						<div>
					@endif
							<input class="form__input" type="text" name="login" value="{{ $prev_login or '' }}">
						</div>
				</div>
				<div class="form-row">
					<label class="form-label">Mon mot de passe</label>
				@if (isset($error_password) && $error_password != "")
					<div class="form__error" data-error="{{ $error_password }}">
				@else
					<div>
				@endif
						<input class="form__input" type="password" name="password">
					</div>
				</div>
			<input class="form__input btn-submit" type="submit" name="submit" value="Je m'inscris">
		</form>
		</div>
	<div>
</div>
@stop