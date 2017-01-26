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
        <section id="age-slider" class="range-slider toto">
            <span class="rangeValues"></span>
            <input value="5" min="0" max="15" type="range">
            <input value="10" min="0" max="15" type="range">
        </section>
        <section id="score-slider" class="range-slider">
            <span class="rangeValues"></span>
            <input value="5" min="0" max="15" type="range">
            <input value="10" min="0" max="15" type="range">
        </section>
    </div>
<script>
const usersList = <?= $result ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geolocator/2.1.0/geolocator.js"></script>
<script src="js/doubleSlider.js"></script>
<script src="js/userFilter.js"></script>
@stop