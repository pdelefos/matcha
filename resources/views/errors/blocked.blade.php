<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap profile-page">
        <div class="profil-error">Vous avez bloqué l'utilisateur <span class="profil-error__login">{{ $user->getLogin() }}</span></div>
        <div class="action-button deblock-btn">
           <a href="{{route('block', ['login' => "dydyl"])}}">débloquer</a>
        </div>
    </div>
@stop