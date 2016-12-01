<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
<div id="complet-profile_modal" class="profile-modal">
    <!-- Modal content -->
    <div class="profile-modal__content">
        <form>
            <input type="radio" name="gender" value="male"><label for="">Homme</label>
            <input type="radio" name="gender" value="female"><label for="">Femme</label>
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