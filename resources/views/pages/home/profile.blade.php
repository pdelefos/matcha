<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap profile-page">
        <div class="profil-box">
            <div class="profil-bar">
                <div class="profil-bar-pic">
                    <img src="../images/mona.jpg" alt="" class="profil-bar-picture">
                </div>
                <div class="profil-bar-center">
                    <div class="profil-bar-center__info">
                        {{ $user->getLogin() }}
                    </div>
                </div>
                <div class="profil-bar-score">
                    <label class="score">0</label>
                </div>
            </div>
          
        </div>
    </div>
@stop