<li class="sidebar-item">
    <a href="{{ route($route) }}" id="{{ $route }}" class="sidebar-link {{ (Route::is($route)) ? 'active' : '' }}">
        {{ $slot }}
    </a>
</li>