<style>
    #menu-icon {
    transition: transform 0.3s ease;
}

.rotate {
    transform: rotate(180deg);
}
</style>

<nav class="navbar navbar-expand px-3 border-bottom d-flex justify-content-between">
    <span class="d-flex">
    <button class="btn menu-btn" id="sidebar-toggle" type="button" " onclick="toggleRotation()"> 
        <img src="{{ asset('img/menu.png') }}" alt="menu" class="img-fluid" id="menu-icon">
    </button>
        <h4 class="menu-title">@yield('nav-title')</h4>
    </span>
    <div class="d-flex align-items-center justify-content-center">
        {{-- Notification --}}
        <div class="dropdown">
            @if(Route::currentRouteName() != "see-all-notifications")
            <span class="notification-icon" id="notificationDropdown" data-bs-toggle="dropdown"
                data-bs-auto-close="outside" aria-expanded="true">
                <i class="fi fi-ss-bell"></i>
                <span class="badge" id="unread-count"></span>
            </span>
            @else
            <span class="notification-icon bg-primary text-white">
                <i class="fi fi-ss-bell"></i>
            </span>
            @endif
            <ul class="dropdown-menu dropdown-menu-end notifications shadow-sm" aria-labelledby="notificationDropdown">
                <div class="dropdown-header">Notifications</div>
                <div class="dropdown-body" id="notification-list">
                    <!-- Notifications will be dynamically loaded here -->
                </div>
                <div class="dropdown-footer d-flex justify-content-between">
                    <a href="{{ route('see-all-notifications') }}" class="fw-bold text-info"><small>See all
                            notifications</small></a>
                    <small class="fw-bold" id="mark-all-read">Mark all as read</small>
                </div>
            </ul>
        </div>
        <div class="">
            <ul class="navbar-nav">
                <li class="nav-item dropdown d-flex">
                    <a href="#" data-bs-toggle="dropdown" class="nav-link ">
                        <x-user-box size="md">{{ substr(auth()->user()->firstname, 0, 1) }}</x-user-box>
                        <div class="d-none d-md-flex flex-column">
                            <span class="user-name">{{ auth()->user()->firstname }}</span>
                            <span class="user-role">{{ auth()->user()->role }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('user.profile')  }}" class="dropdown-item">Profile</a>
                        @if(auth()->user()->role === "Admin")
                        <a href="{{ route('admin.settings') }}" class="dropdown-item">Settings</a>
                        @endif
                        <x-logout />
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
   function toggleRotation() {
    const menuIcon = document.getElementById("menu-icon");
    menuIcon.classList.toggle("rotate");
}

</script>