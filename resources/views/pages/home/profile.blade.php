<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap profile-page">
        <div class="profile-box">
            <div class="profile-box-header">
                <div class="profile-box-header__pic">
                    
                </div>
                <div class="profile-box-header__infos">
                    {{ $user->getSexe() }}
                </div>
            </div>
        </div>
    </div>
@stop