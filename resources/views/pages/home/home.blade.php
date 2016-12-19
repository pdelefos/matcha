<?php
$page_need = array(
    'url_app' => route('root')
);
?>

@extends('layouts.default')

@section('content')

    @if (isset($user_completed) && !$user_completed)
        @include('modals.profile')
    @endif

    <div class="app-wrap home-page">

    </div>

@stop