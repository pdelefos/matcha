<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap notification-page">
        <div class="visit-notif-container">
            <div class="notif-box">
            <label for="" class="notif-title">Notifications</label>
                <ul class="list-visit">
                    @foreach($notifs as $notif)
                        @if ($notif->{'seen'} == 0)
                            <li class="item-visit item-visit-unseen">{{ $notif->{'login'} }} vous à {{ $notif->{'description'} }}</li>
                        @else
                            <li class="item-visit">{{ $notif->{'login'} }} vous à {{ $notif->{'description'} }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="visit-box">
            <label for="" class="notif-title">Historique des visites</label>
                <ul class="list-visit">
                    @foreach($visits as $visit)
                        @if ($visit->{'seen'} == 0)
                            <li class="item-visit item-visit-unseen">{{ $visit->{'login'} }} à visité votre profil</li>
                        @else
                            <li class="item-visit">{{ $visit->{'login'} }} à visité votre profil</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop