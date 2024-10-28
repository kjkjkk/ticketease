<li class="sidebar-item">
    <a href="#"
        class="sidebar-link sidebar-dropdown {{ in_array(Route::currentRouteName(), ['admin.ticket-request', 'admin.walk-in']) ? 'active show' : '' }}"
        data-bs-target="#pages" data-bs-toggle="collapse"
        aria-expanded="{{ request()->is('admin/ticket-request') || request()->is('admin/walk-in') || request()->is('admin/ticket-request/queue') ? 'true' : 'false' }}">
        <i class="fi fi-ss-ballot"></i>
        Request Management
    </a>
    <ul id="pages"
        class="sidebar-dropdown list-unstyled collapse {{ request()->is('admin/ticket-request') || request()->is('admin/walk-in') || request()->is('admin/ticket-request/queue')? 'show' : '' }}"
        data-bs-parent="#sidebar">
        <li class="sidebar-item">
            <a href="{{ route('admin.walk-in') }}"
                class="sidebar-dropdown-item {{ request()->is('admin/walk-in') ? 'active' : '' }}">
                Walk in
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.ticket-request.queue') }}"
                class="sidebar-dropdown-item {{ request()->is('admin/ticket-request/queue') ? 'active' : '' }}">
                Ticket queue
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.ticket-request') }}"
                class="sidebar-dropdown-item {{ request()->is('admin/ticket-request')  ? 'active' : '' }}">
                Ticket requests
            </a>
        </li>
    </ul>
</li>