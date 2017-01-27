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
        <?php var_dump(json_encode((array)$user)) ?><br/>
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
    </div>
<script>
const usersList = <?= $result ?>;
const currUser = <?= json_encode((array)$user) ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geolocator/2.1.0/geolocator.js"></script>
<script src="js/doubleSlider.js"></script>
<script src="js/userFilter.js"></script>
@stop