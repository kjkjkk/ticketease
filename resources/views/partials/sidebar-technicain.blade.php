@section('nav-title', 'Profile Setup')
@if (!auth()->user()->isProfileIncomplete())
<aside id="sidebar">
    <div class="h-100">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="ms-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo img-fluid">
                Ticket<span class="text-logo-dark">Ease</span>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header mt-3">
                Navigation
            </li>
            <x-template.sidebar-item route="technician.dashboard">
                <i class="fi fi-ss-layout-fluid me-1 me-2"></i>
                Dashboard
            </x-template.sidebar-item>
            <x-template.sidebar-item route="shared.walk-in">
                <i class="fi fi-ss-shoe-prints me-2"></i>
                Walk-in Request
            </x-template.sidebar-item>

            <x-template.sidebar-item route="shared.my-tickets">
                <i class="fi fi-ss-clipboard-list me-2"></i>
                My Tickets
            </x-template.sidebar-item>

            <x-template.sidebar-item route="shared.calendar">
                <i class="fi fi-ss-calendar me-2"></i>
                Calendar
            </x-template.sidebar-item>

            <x-template.sidebar-item route="shared.manage-users">
                <i class="fi fi-ss-user-gear me-2"></i>
                Manage Users
            </x-template.sidebar-item>
            <x-template.sidebar-item route="technician.history">
                <i class="fi fi-ss-time-past me-2"></i>
                History
            </x-template.sidebar-item>
        </ul>
    </div>
</aside>
@endif