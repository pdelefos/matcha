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
        @if($search)
            @include('modals.search')
        @endif
        <div class="search-bar">
            <a href="{{ route('recherche') }}" class="search-link">rechercher</a>
        </div>
        <div class="filter-sort-bar">
            <div class="filter-bar">
                <div class="filter-bar__row">
                    <section id="age-slider" class="range-slider filter-slider">
                        <label class="filter-label" for="age-slider">age :</label>
                        <span class="rangeValues"></span> ans
                        <input type="range">
                        <input type="range">
                    </section>
                    <section id="location-slider"class="range-slider filter-slider">
                        <label class="filter-label" for="location-slider">distance :</label>
                        <span class="rangeValues"></span> km
                        <input type="range">
                    </section>
                </div>
                <div class="filter-bar__row">
                    <section id="score-slider" class="range-slider filter-slider">
                        <label class="filter-label" for="score-slider">score :</label>
                        <span class="rangeValues"></span> pts
                        <input type="range">
                        <input type="range">
                    </section>
                    <section id="interet-slider" class="range-slider filter-slider">
                        <label class="filter-label" for="interet-slider">interets :</label>
                        <span class="rangeValues"></span>
                        <input type="range">
                    </section>
                </div>
            </div>
            <div class="sort-bar">
                <select class="sort" id="">
                    <option value="age">age</option>
                    <option value="distance">distance</option>
                    <option value="score">score</option>
                    <option value="interets">interets</option>
                </select>
                <div class="custom-radio">
                    <ul>
                        <li>
                            <input type="radio" name="sortOrder" id="order-asc" value="asc">
                            <label for="order-asc">Croissant</label>
                            <div class="check"></div>
                        </li>
                        <li>
                            <input type="radio" name="sortOrder" id="order-desc" value="desc">
                            <label for="order-desc">Décroissant</label>
                            <div class="check"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="display-users">
            <ul class="user-list">

            </ul>
        </div>
    </div>
@if(!$search)
<script id="spooky">
const usersList = <?= $result ?>;
const currUser = <?= $currUser ?>;
const rootPath = "<?= route('root') ?>";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geolocator/2.1.0/geolocator.js"></script>
<script src="js/doubleSlider.js"></script>
<script src="js/userFilter.js"></script>
@endif
@stop