<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')

    @if($modification)
        @include('modals.modification')
    @endif
    @if($modPicture)
        @include('modals.upload')
    @endif
    @if($modPhotos)
        @include('modals.uploadPhotos')
    @endif
    <div class="app-wrap profile-page">
        <div class="profil-box">
            <div class="profil-bar">
                <div class="profil-bar-picplace">
                    <a href="{{ route('profilpic') }}">
                        <div class="profil-bar__picture" style="background-image:url({{route('root') . '/' . $user->getAvatar()}})"></div>
                    </a><tab>
                </div>
                <div class="profil-bar-login">
                    {{ $user->getLogin() }}
                    <span class="profil-bar-fullname">({{ $user->getFuscNames() }})</span>
                    <span class="sexe-symbol">
                        @if ($user->getSexe() == "homme")
                            ♂
                        @else
                            ♀
                        @endif
                    </span>
                </div>
                <div class="profil-bar-interests">
                    @foreach ($user->getInterests() as $value)
                        <div class="profil-bar-interests__item">
                            #{{ $value }}
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('modification') }}" class="white-link"><div data-icon="ei-gear" data-size="m" class="profil-mod"></div></a>
            </div>
            <div class="profil-infobar">
                <div class="profil-infobar-wrap">
                    <div class="profil-infobar__item profil-infobar__score">
                        <div class="item-value">0</div>
                        <div data-icon="ei-trophy" data-size="m"></div>
                    </div>
                    <div class="profil-infobar__item profil-infobar__age">
                        <div class="item-value">{{ $user->getAge() }} ans</div>
                        <div data-icon="ei-calendar" data-size="m"></div>
                    </div>
                    <div class="profil-infobar__item profil-infobar__orientation">
                        <div class="item-value">{{ $user->getOrientation() }}</div>
                        <div data-icon="ei-cart" data-size="m"></div>
                    </div>
                    <div class="profil-infobar__item profil-infobar__localisation">
                        <div class="item-value">{{ $user->getCity() }}</div>
                        <div data-icon="ei-location" data-size="m"></div>
                    </div>
                </div>
            </div>
            <div class="profil-bio">
                {{ $user->getPresentation() }}
            </div>
            <div class="profil-photo-wrap">
             
                    <div class="profil-photo_item">
                        <a href="{{route('root')}}/home/photo/1"><img class="profil-photos" src="{{route('root')}}/pictures/pdelefos/avatar.jpeg"></a>
                    </div>
             
                    <div class="profil-photo_item">
                        <a href="{{route('root')}}/home/photo/2"><img class="profil-photos" src="{{route('root')}}/pictures/pdelefos/avatar.jpeg"></a>
                    </div>
             
                    <div class="profil-photo_item">
                        <a href="{{route('root')}}/home/photo/3"><img class="profil-photos" src="{{route('root')}}/pictures/pdelefos/avatar.jpeg"></a>
                    </div>
             
                    <div class="profil-photo_item">
                        <a href="{{route('root')}}/home/photo/4"><img class="profil-photos" src="{{route('root')}}/pictures/pdelefos/avatar.jpeg"></a>
                    </div>
            </div>
        </div>
    </div>
@stop