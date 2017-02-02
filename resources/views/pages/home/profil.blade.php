<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap profile-page">
        <div class="profil-box">
            <div class="profil-bar">
                <div class="profil-bar-picplace">
                    <div class="profil-bar__picture_noh" style="background-image:url({{route('root') . '/' . $user->getAvatar()}})"></div>
                </div>
                <div class="profil-bar-login">
                    <span>{{ $user->getLogin() }}</span>
                    <span class="status status-off">{{$user->getLastVisit()}}</span>
                </div>
                <div class="profil-bar-info">
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
                <div class="like">
                    {{$likeStatus}}
                </div>
            </div>
            <div class="profil-infobar">
                <div class="profil-infobar-wrap">
                    <div class="profil-infobar__item profil-infobar__score">
                        <div class="item-value">{{ $user->getScore() }} pts</div>
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
                <?php $ind = 1; ?>
                @foreach($user->getPhotos() as $photo)
                    <div class="profil-photo_item">
                    @if(!empty($photo['src']))
                            <img class="profil-photos" src="{{route('root') . '/' . $photo['src']}}">
                    @endif
                    <?php $ind++; ?>
                    </div>
                @endforeach
            </div>
            <div class="action-user">
                <a href="{{route('block', ['login' => $user->getLogin()])}}" class="">
                    <div class="action-button block-user">
                        bloquer
                    </div>
                </a>
                <a href="{{route('report', ['login' => $user->getLogin()])}}" class="">
                    <div class="action-button report-user">
                        signaler
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script>
        const likeButton = document.querySelector('.like');
         function doLike() {
            const root = "<?= route('like', ['login' => $user->getLogin()]) ?>";
            $.get(root, (data, status) => {
                switch (data) {
                    case 'like':
                        likeButton.innerHTML = 'tu like';
                        return ;
                    case 'unlike':
                        likeButton.innerHTML = 'tu unlike';
                        return ;
                    case 'match':
                        likeButton.innerHTML = 'c\'est un match';
                        return ;
                    case 'unmatch':
                        likeButton.innerHTML = 'c\'est un unmatch';
                        return ;
                    case 'ownlike':
                        likeButton.innerHTML = 'tu ne peux pas te liker';
                        return ;
                    case 'blocked':
                        likeButton.innerHTML = 'tu as bloqué cet utilisateur';
                        return ;
                    case 'nopicture':
                        likeButton.innerHTML = 'il faut une photo de profil';
                        return ;
                    default:
                        break;
                }
            }) 
         }
         likeButton.addEventListener('click', doLike);
    </script>
    <script>
        const statusElem = document.querySelector('.status');

        function toggleStatus(status) {
            if (status == '1'){
                statusElem.classList.remove('status-off');
                statusElem.classList.add('status-on');
                statusElem.innerHTML = "en ligne";
            } else {
                statusElem.classList.remove('status-on');
                statusElem.classList.add('status-off');
                statusElem.innerHTML = status;
            }
        }

        function notifOnline() {
            const root = "<?= route('userIsOnline', ['login' => $user->getLogin()]) ?>";
            $.get(root, (data, status) => {
                toggleStatus(data);
            })
        }
        setInterval(notifOnline, 1000);
        // notifOnline()
    </script>
@stop