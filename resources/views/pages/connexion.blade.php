<?php
$page_need = array(
	'url_app' => route('root')
);
if (isset($errorHandler)) {
	$error_login = $errorHandler->first('login');
	$error_password = $errorHandler->first('password');
}
if (isset($prev_values)) {
	$prev_login = $prev_values->input('login');
}
?>
@extends('layouts.default_noheader', $page_need)
@section('content')
<div class='flex-container'>
	<a href="{{ $page_need['url_app'] }}/" class="connection-link link-btn">s'inscrire</a>
	<div class="home-login">
		<div class="logo-login">
			<h2 class="logo">
				<div class="wavetext"></div>
			</h2>
		</div>
		<div class="form__login form__box">
		<h2 class="form__title">CONNEXION</h2>
		<form action="#" method="post" class="form-login">
			<div class="form-row">
				<label class="form-label">Mon login</label>
				@if (isset($error_login) && $error_login != "")
					<div class="form__error" data-error="{{ $error_login }}">
				@else
					<div>
				@endif
						<input class="form__input register-input" type="text" name="login" alue="{{ $prev_login or '' }}">
					</div>
			</div>
			<div class="form-row">
				<label class="form-label">Mon mot de passe</label>
				@if (isset($error_password) && $error_password != "")
					<div class="form__error" data-error="{{ $error_password }}">
				@else
					<div>
				@endif
						<input class="form__input register-input" type="password" name="password">
					</div>
			</div>
			<input class="form__input btn-submit" type="submit" name="submit" value="C'est parti">
			</br><a href="{{ route('recover') }}" class="forget-link">j'ai perdu mon mot de passe</a>
		</form>
		</div>
	</div>
</div>
@stop