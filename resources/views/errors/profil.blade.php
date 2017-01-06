<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap profile-page">
        <div class="profil-error">¯\_(ツ)_/¯ l'utilisateur <span class="profil-error__login">{{ $login }}</span> n'existe pas ... encore.</div>
    </div>
@stop