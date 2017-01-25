<?php
$page_need = array(
    'url_app' => route('root')
);
?>

@extends('layouts.default')

@section('content')

    @if (!$user->getCompleted())
        @include('modals.profile')
    @endif
    <div class="app-wrap home-page">
        {{ var_dump($result) }}
    </div>
<script>
    const usersList = <?= $result ?>;
    console.log(usersList);
</script>
@stop