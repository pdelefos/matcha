<?php
$page_need = array(
	'url_app' => route('root')
);
if (isset($errorHandler)) {
	$error_password = $errorHandler->first('password');
}
?>
@extends('layouts.default_noheader', $page_need)
@section('content')
<div class='flex-container'>
	<a href="{{ route('connection') }}" class="connection-link link-btn">se connecter</a>
	<div class="home-login">
		<div class="form__login form__box">
		<h2 class="form__title">NOUVEAU MOT DE PASSE</h2>
		<form action="#" method="post" class="form-login">
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
			<input class="form__input btn-submit" type="submit" name="submit" value="changer">
		</form>
		</div>
	</div>
</div>
@stop