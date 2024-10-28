<nav class="navbar navbar-expand px-3 border-bottom d-flex justify-content-between">
    <div class=" d-flex">
        <div class="nav-logo">
            <img src="{{ asset('img/logo.png') }}" alt="" class="logo img-fluid">
            <div class="logo-name">
                Ticket<span class="text-logo-dark">Ease</span>
            </div>
        </div>

    </div>
    <div class="d-flex align-items-center justify-contet-center">
        <div class="dropdown d-block d-md-none">
            <button class="btn btn-lg" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fi fi-ss-menu-burger"></i>
            </button>
            <ul class="dropdown-menu active">
                @if (auth()->user()->isProfileIncomplete())
                <li><a class="dropdown-item {{ request()->is('profile-setup') || request()->is('verify') ? 'dropdown-active' : '' }}"
                        href="{{ route('profile-setup') }}">Profile Setup</a></li>
                @else
                    <li><a class="dropdown-item {{ request()->is('requestor/home') ? 'dropdown-active' : '' }}"
                            href="{{ route('requestor.home') }}">Home</a></li>
                    <li><a class="dropdown-item {{ request()->is('requestor/create-ticket') ? 'dropdown-active' : '' }}"
                            href="{{ route('requestor.create-ticket') }}">Create Ticket</a></li>
                    <li><a class="dropdown-item {{ request()->is('requestor/my-requests') ? 'dropdown-active' : '' }}"
                            href="{{ route('requestor.my-requests') }}">My Requests</a></li>
                @endif
            </ul>
        </div>
        <div class="requestor-nav d-none d-md-block">
            <ul>
                @if (auth()->user()->isProfileIncomplete())
                <li
                    class="requestor-nav-link {{ request()->is('profile-setup') || request()->is('verify') ? 'active' : '' }}">
                    <a href="{{ route('profile-setup') }}">Profile Setup</a>
                </li>
                @else
                <li class="requestor-nav-link {{ request()->is('requestor/home') ? 'active' : '' }}">
                    <a href="{{ route('requestor.home') }}">Home</a>
                </li>
                <li class="requestor-nav-link {{ request()->is('requestor/create-ticket') ? 'active' : '' }}">
                    <a href="{{ route('requestor.create-ticket') }}">Create&nbsp;Ticket</a>
                </li>
                <li class="requestor-nav-link {{ request()->is('requestor/my-requests') ? 'active' : '' }}">
                    <a href="{{ route('requestor.my-requests') }}">My&nbsp;Requests</a>
                </li>
                @endif
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
                        <a href="{{ route('user.profile') }}" class="dropdown-item">Profile</a>
                        <x-logout />
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>