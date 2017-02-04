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
                    @forEach($usersConv as $user)
                        <li class="chat-users__item" data-name="{{ $user->{'login'} }}">{{ $user->{'login'} }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="chat-conversation">
                <div class="chat-conversation__window">
                <ul class="chat-conversation__list">
                </ul>
                </div>
                <div class="chat-conversation__form">
                    <form action="" class="send-message">
                        <input type="text" class="chat-conversation__input">
                        <input type="submit" class="chat-conversation__submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const convUsers = document.querySelector('.chat-users__list');
        const usersPool = convUsers.querySelectorAll('.chat-users__item');
        const chatWindow = document.querySelector('.chat-conversation__window');
        const conversationList = document.querySelector('.chat-conversation__list');
        const formSendMessage = document.querySelector('.send-message');
        let refresh;
        let currentDest;

        function getCurrentConv(e) {
            if (typeof refresh !== 'undefined')
                clearInterval(refresh);
            const currentConvUser = this.dataset.name;
            setActive(currentConvUser);
            currentDest = this.dataset.name;
            const pathGetConv = `<?= route('root') ?>/chat/getconversation/${currentConvUser}`;
            getConversation(pathGetConv);
            refresh = setInterval(getConversation.bind(null, pathGetConv), 1000);
        }

        function getConversation(route) {
            $.get(route, (data, status) => {
                const ret = JSON.parse(data);
                if (typeof ret.error === 'undefined'){
                    conversationList.innerHTML = ret.map(msg => {
                        const typeMsg = (msg.sender == 'dest') ? `chat-item__dest` : `chat-item__expe`;
                        return `
                            <li class="chat-convertation__item"><div class="${typeMsg}">${msg.msg}</div></li>
                        `;
                    }).join('');
                } else {
                    conversationList.innerHTML = '';
                }
                chatWindow.scrollTop = chatWindow.scrollHeight;
            })
        }

        function sendMessage(e) {
            e.preventDefault();
            const input = this.querySelector('.chat-conversation__input');
            const pathSendMsg = "<?= route('sendmessage') ?>";
            if (input.value !== '' && typeof currentDest !== 'undefined') {
                $.ajax({
                    url: pathSendMsg,
                    type: "post",
                    data: {
                        msg: input.value,
                        dest: currentDest
                    },
                    success: function (retour) {
                        input.value = '';
                        chatWindow.scrollTop = chatWindow.scrollHeight;                        
                    }
                })
            }
        }

        formSendMessage.addEventListener('submit', sendMessage);
        usersPool.forEach(elem => {
            elem.addEventListener('click', getCurrentConv);
        })

        function setActive(user) {
            usersPool.forEach(elem => {
                elem.classList.remove('chat-users__item-active')                
                if (elem.dataset.name == user)
                    elem.classList.add('chat-users__item-active')
            })
        }
    </script>
@stop