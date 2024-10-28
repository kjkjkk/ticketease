@extends('layouts.master')
@section('title', 'TicketEase | Notification')
@section('nav-title', 'Notifications')
@section('content')
<div class="row p-3">
    <div class="col-12 col-md-10 col-lg-8 col-xl-6 mx-auto">
        <button id="showToastBtn">Show Toastr Notification</button>
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Unread notifications
                (<span id="unread-count-seeAllNotfication"></span>)
            </div>
            <div class="notifications-page">
                <div class="notifications-body">
                    @foreach ($notifications as $notification)
                    <div class="notification-container {{ $notification->if_read ? '' : 'unread' }}">
                        <div class="icon-circle">
                            <img src="{{ url('img/notification/' . $notification->icon . '.png') }}" alt=""
                                class="img-fluid">
                        </div>
                        <div class="notification-content">
                            <div class="d-flex flex-wrap justify-content-between">
                                <h6 class="fw-semibold text-{{ $notification->if_read ? 'secondary' : 'dark' }}">
                                    {{ $notification->title }}
                                </h6>
                                <small>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </div>
                            <small class="message mb-0 text-secondary">{{ $notification->message }}</small>
                            <div class="d-flex justify-content-between text-secondary">
                                <a href="{{ route('mark-read-or-unread', $notification) }}" class="n-mt-1">
                                    <small class="fw-bold mark-unread">
                                        Mark as {{ $notification->if_read ? 'unread' : 'read' }}
                                    </small>
                                </a>
                                @if($notification->if_read)
                                <i class="fi fi-ss-check-circle text-primary"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('mark-all-as-read') }}" class="fw-bold text-secondary">
                    Mark all as read
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("showToastBtn").addEventListener("click", function() {
            // Toastr options
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-bottom-right";
            toastr.options.timeOut = 5000; // Duration in milliseconds
            
            // Trigger the toastr notification
            toastr.info("This is a test notification!");
        });
</script>
@endsection