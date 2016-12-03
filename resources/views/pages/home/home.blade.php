<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
<div id="complet-profile_modal" class="profile-modal">
    <div class="profile-modal__content">
        <h2 class="profile-modal__title">On a besoin de plus d'info !</h2>
        <form class="profile-form">
            <ul>
                <li>
                    <input type="radio" name="gender" id="m-option">
                    <label for="m-option">Homme</label>
                    <div class="check"></div>
                </li>
                <li>
                    <input type="radio" name="gender" id="f-option">
                    <label for="f-option">Femme</label>
                    <div class="check"></div>
                </li>
            </ul>
            </br>
            <select>
                <option value="0">recherche un homme</option>
                <option value="1">recherche une femme</option>
                <option value="2">recherche les deux</option>
            </select>
            </br>
            <label for="">bio</label><textarea rows="3" cols="20"></textarea>
            </br>
            <label for="">Age</label><input type="date" name="" value="">
            </br>
            <label for="">interets</label><input type="text" name="" value="">
            </br>
            <label for="">photos</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
</div>

<div class="app-wrap home-page">
</div>
@stop