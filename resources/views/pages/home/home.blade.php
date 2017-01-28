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
        <label for="age-slider">age</label>
        <section id="age-slider" class="range-slider">
            <span class="rangeValues"></span> ans
            <input type="range">
            <input type="range">
        </section>
        <label for="location-slider">distance</label>
        <section id="location-slider"class="range-slider">
            <span class="rangeValues"></span> km
            <input type="range">
        </section>
        <label for="score-slider">score</label>
        <section id="score-slider" class="range-slider">
            <span class="rangeValues"></span> pts
            <input type="range">
            <input type="range">
        </section>
        <label for="interet-slider">interets</label>
        <section id="interet-slider" class="range-slider">
            <span class="rangeValues"></span>
            <input type="range">
        </section>
        <select class="sort" id="">
            <option value="age">age</option>
            <option value="distance">distance</option>
            <option value="score">score</option>
            <option value="interets">interets</option>
        </select>
    </div>
<script id="spooky">
const usersList = <?= $result ?>;
const currUser = <?= $currUser ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geolocator/2.1.0/geolocator.js"></script>
<script src="js/doubleSlider.js"></script>
<script src="js/userFilter.js"></script>
@stop