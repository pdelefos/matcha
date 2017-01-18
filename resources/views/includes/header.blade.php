<ul>
    @if ($request->path() == "home")
        <li><a href="{{ route('home') }}" class="navbar-item navbar__home navbar-item__selected"><span class="home-logo">M</span></a></li>
    @else
        <li><a href="{{ route('home') }}" class="navbar-item navbar__home"><span class="home-logo">M</span></a></li>
    @endif
    @if ($request->path() == "home/profil/me")
        <li><a href="{{ route('profile') }}/me" class="navbar-item navbar__profile navbar-item__selected"><div data-icon="ei-user" data-size="m" class="ei-position"></div></a></li>
    @else
        <li><a href="{{ route('root') }}/home/profil/me" class="navbar-item navbar__profile"><div data-icon="ei-user" data-size="m" class="ei-position"></div></a></li>
    @endif
    @if ($request->path() == "home/notifications")
        <li><a href="{{ route('notif') }}" class="navbar-item navbar__notification navbar-item__selected"><div data-icon="ei-heart" data-size="m" class="ei-position"></div></a></li>
    @else
        <li><a href="{{ route('notif') }}" class="navbar-item navbar__notification"><div data-icon="ei-heart" data-size="m" class="ei-position"></div></a></li>
    @endif
    @if ($request->path() == "home/chat")
        <li><a href="{{ route('chat') }}" class="navbar-item navbar__chat navbar-item__selected"><div data-icon="ei-comment" data-size="m" class="ei-position"></div></a></li>
    @else
        <li><a href="{{ route('chat') }}" class="navbar-item navbar__chat"><div data-icon="ei-comment" data-size="m" class="ei-position"></div></a></li>
    @endif
    <li><a href="{{ route('deconnexion') }}" class="navbar-item navbar__logout"><div data-icon="ei-close-o" data-size="m" class="ei-position"></div></a></li>
</ul>