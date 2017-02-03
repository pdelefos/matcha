<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')
@section('content')
    <div class="app-wrap chat-page">
        <div class="chat-container">
            <div class="chat-users">
                <ul class="chat-users__list">
                    <li class="chat-users__item">sulo</li>
                    <li class="chat-users__item">silbo</li>
                    <li class="chat-users__item">poulet</li>
                    <li class="chat-users__item">grefayce</li>
                </ul>
            </div>
            <div class="chat-conversation">
                <div class="chat-conversation__window">
                
                </div>
                <div class="chat-conversation__form">
                    <form action="">
                        <input type="text" class="chat-conversation__input">
                        <input type="submit" class="chat-conversation__submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop