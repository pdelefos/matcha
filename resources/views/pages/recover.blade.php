<?php
$page_need = array(
	'url_app' => route('root')
);
if (isset($errorHandler)) {
	$error_email = $errorHandler->first('email');
}
if (isset($prev_values)) {
	$prev_email = $prev_values->input('email');
}
?>
@extends('layouts.default_noheader', $page_need)
@section('content')
<div class='flex-container'>
	<a href="{{ route('connection') }}" class="connection-link link-btn">se connecter</a>
	<div class="home-login">
		<div class="form__login form__box">
		<h2 class="form__title">RÉCUPÉRATION MOT DE PASSE</h2>
		<form action="#" method="post" class="form-login">
			<div class="form-row">
				<label class="form-label">Mon email</label>
				@if (isset($error_email) && $error_email != "")
					<div class="form__error" data-error="{{ $error_email }}">
				@else
					<div>
				@endif
						<input class="form__input register-input" type="text" name="email" alue="{{ $prev_email or '' }}">
					</div>
			</div>
			<input class="form__input btn-submit" type="submit" name="submit" value="envoyer email">
		</form>
		</div>
	</div>
</div>
@stop