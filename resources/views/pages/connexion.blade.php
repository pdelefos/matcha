<?php
$page_need = array(
	'url_app' => route('root')
);
?>
@extends('layouts.default_noheader', $page_need)
@section('content')
<div class="home-login">
	<h2 class="form__title">Se connecter</h2>
	<form action="#" method="post" class="form-login">
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
		<input class="form-register__input btn-submit btn-hover" type="submit" name="submit" value="Match !">
	</form>
</div>
@stop