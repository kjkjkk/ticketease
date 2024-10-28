@extends('layouts.master')
@section('title', 'TicketEase | Calendar')
@section('nav-title', 'Calendar')
@section('content')
<div class="tickets-wrapper">
    <button class="sliding-panel-toggle" type="button" style="z-index: 2;">
        <span class="material-icons sp-icon-open"><i class="fi fi-ss-angle-circle-left"></i></span>
        <span class="material-icons sp-icon-close"><i class="fi fi-ss-angle-circle-right"></i></span>
        <small class="d-none d-md-block fw-semibold mb-1 ms-2">MY TICKETS</small>
    </button>
    <div class="sliding-panel">
        <div class="tickets-container mt-2 mb-2">
            @if($tickets->isEmpty())
            <h5 class="fw-semibold text-center text-white">No tickets</h5>
            @else
            @foreach ($tickets as $ticket)
            <div class="col">
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center">
                        <div class="circle-sm bg-light-subtle">
                            <i class="fi fi-ss-ticket mt-1"></i>
                        </div>
                        <small class="fw-semibold ms-2">Ticket No.</small>
                        <h6 class="font-weight-bold ms-2 mt-2">#{{ $ticket->id }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex mb-3">
                                <x-user-box size="md">{{ substr($ticket->ticket->requestor->firstname, 0, 1)
                                    }}
                                </x-user-box>
                                <span class="d-flex flex-column ms-1">
                                    <span class="fw-semibold">
                                        {{ $ticket->ticket->requestor->firstname . ' ' .
                                        $ticket->ticket->requestor->lastname }}
                                    </span>
                                    <small class="n-mt-1"><strong>From: </strong>{{
                                        Str::limit($ticket->ticket->district->district_name, 30)
                                        }}</small>
                                </span>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="d-flex flex-column ms-1">
                                    <strong><i class="fi fi-ss-list-dropdown"></i> Nature</strong>
                                    <span class="n-mt-1">
                                        {{ $ticket->ticket->ticketNature->ticket_nature_name }}
                                    </span>
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="d-flex flex-column ms-1">
                                    <strong><i class="fi fi-ss-calendar-day"></i> Requested</strong>
                                    <span class="n-mt-1">
                                        {{ $ticket->ticket->created_at->format('F j, Y g:i a') }}
                                    </span>
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="d-flex flex-column ms-1">
                                    <strong><i class="fi fi-ss-phone-rotary"></i> Contact No.</strong>
                                    <span class="n-mt-1">
                                        {{ $ticket->ticket->requestor->contact_number }}
                                    </span>
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="d-flex flex-column ms-1">
                                    <strong><i class="fi fi-ss-envelope"></i> E-Mail</strong>
                                    <span class="n-mt-1">
                                        {{ $ticket->ticket->requestor->email }}
                                    </span>
                                </small>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer col-12 d-flex justify-content-end">
                        <a href="{{ route('shared.show-ticket', ['id' => $ticket->ticket_id, 'route' => Route::currentRouteName()]) }}"
                            class="btn btn-sm btn-primary me-2 fw-semibold">View Details</a>
                        <button class="btn btn-sm btn-success fw-semibold" data-bs-toggle="modal"
                            data-bs-target="#createSchedule-{{$ticket->ticket->id ?? null}}">Create
                            Schedule</button>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
<div class="p-4">
    <!--CALENDAR-->
    <div class="col-12" style="z-index: 0;">
        <div id='calendar' class="card shadow-sm bg-white p-3 rounded"></div>
    </div>
</div>

<script>
    document.querySelector(".sliding-panel-toggle").addEventListener("click", () => {
            document.querySelector(".tickets-wrapper").classList.toggle("sliding-panel-open");
        });
</script>

<input type="hidden" id="schedules-data" value='@json($schedules)'>
<script>
    $(document).ready(function() {
            var schedules = JSON.parse($('#schedules-data').val());
            var calendarEl = $('#calendar');

            var calendar = new FullCalendar.Calendar(calendarEl[0], {
                initialView: 'dayGridMonth',
                selectable: true,
                //selectHelper: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                events: schedules.map(function(schedule) {
                    return {
                        title: 'Ticket #' + schedule.ticket_id,
                        start: schedule.start_time,
                        end: schedule.end_time,
                        color: '#006769',
                        extendedProps: {
                            schedId: schedule.id,
                            ticketId: schedule.ticket_id,
                            startTime: schedule.start_time,
                            endTime: schedule.end_time,
                            comments: schedule.comments,
                            dateAssigned: schedule.date_assigned,
                            ticketNature: schedule.ticket_nature_name,
                            district: schedule.district,
                            department: schedule.department,
                            created_at: schedule.created_at,
                        }
                    };
                }),
                eventClick: function(info) {
                    $('#schedId').val(info.event.extendedProps.schedId);
                    $('#ticketId').text(info.event.extendedProps.ticketId);
                    $('#startTime').val(info.event.extendedProps.startTime);
                    $('#endTime').val(info.event.extendedProps.endTime);
                    $('#comments').val(info.event.extendedProps.comments);
                    $('#dateAssigned').text(info.event.extendedProps.dateAssigned);
                    $('#ticketNature').text(info.event.extendedProps.ticketNature);
                    $('#district').text(info.event.extendedProps.district);
                    $('#department').text(info.event.extendedProps.department);
                    $('#created_at').text(info.event.extendedProps.created_at);

                    $('#scheduleDetails').modal('show');

                },

                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('timeGridDay');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                }
            });

            calendar.render();
        });
</script>
@if($tickets->isNotEmpty())
@foreach($tickets as $ticket)
@include('pages.shared.modals.create-schedule')
@include('pages.shared.modals.view-details')
@endforeach
@endif
@include('pages.shared.modals.schedule-details')
<script src="{{ asset('js/dependencies/fullcalendar.index.global.min.js') }}"></script>
{{-- @vite(['public/js/dependencies/fullcalendar.index.global.min.js']) --}}
@endsection