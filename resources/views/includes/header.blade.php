<ul>
    @if ($request->path() == "home")
        <li><a href="{{ route('home') }}" class="navbar-item navbar__home navbar-item__selected"><span class="home-logo">M</span></a></li>
    @else
        <li><a href="{{ route('home') }}" class="navbar-item navbar__home"><span class="home-logo">M</span></a></li>
    @endif
    @if ($request->path() == "profil/user/me")
        <li><a href="{{ route('profile', ['login' => 'me']) }}" class="navbar-item navbar__profile navbar-item__selected"><div data-icon="ei-user" data-size="m" class="ei-position"></div></a></li>
    @else
        <li><a href="{{ route('profile', ['login' =>'me']) }}" class="navbar-item navbar__profile"><div data-icon="ei-user" data-size="m" class="ei-position"></div></a></li>
    @endif
    @if ($request->path() == "home/notifications")
        <li><a href="{{ route('notif') }}" class="navbar-item navbar__notification navbar-item__selected"><div data-icon="ei-heart" data-size="m" class="ei-position"></div><span class="notif-badge"></span></a></li>
    @else
        <li><a href="{{ route('notif') }}" class="navbar-item navbar__notification"><div data-icon="ei-heart" data-size="m" class="ei-position"></div><span class="notif-badge"></span></a></li>
    @endif
    @if ($request->path() == "home/chat")
        <li><a href="{{ route('chat') }}" class="navbar-item navbar__chat navbar-item__selected"><div data-icon="ei-comment" data-size="m" class="ei-position"></div><span class="msg-badge"></span></a></li>
    @else
        <li><a href="{{ route('chat') }}" class="navbar-item navbar__chat"><div data-icon="ei-comment" data-size="m" class="ei-position"></div><span class="msg-badge"></span></a></li>
    @endif
    <li><a href="{{ route('deconnexion') }}" class="navbar-item navbar__logout"><div data-icon="ei-close-o" data-size="m" class="ei-position"></div></a></li>
</ul>
<script>
    $(document).ready(function () {
        const notifBadge = document.querySelector('.notif-badge');
        const msgBadge = document.querySelector('.msg-badge');

        function getNotifBadge() {
            const root = "<?= route('getnotif') ?>";
            $.get(root, (data, status) => {
                if (data > 0)
                    notifBadge.innerHTML = data;
            })
        }
        setInterval(getNotifBadge, 1000);

        function getMsgBadge() {
            const root = "<?= route('getmsgnotif') ?>";
            $.get(root, (data, status) => {
                if (data > 0)
                    msgBadge.innerHTML = data;
                else
                    msgBadge.innerHTML = "";
            })
        }
        setInterval(getMsgBadge, 1000);
    })
</script>