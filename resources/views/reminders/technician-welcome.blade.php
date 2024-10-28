<style>
    .reminder-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        margin-top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(.5px);
        transition: opacity 0.3s ease;
    }

    .reminder-header {
        background-color: var(--bs-indi);
        padding: 20px 0;
        display: flex;
        justify-content: center;
    }

    .ticket-gif {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .reminder-container {
        background-color: #eee;
        margin: auto;
        margin-top: 4%;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .reminders-content {
        padding: 20px;
    }

    .ticket-list {
        height: 100px;
        overflow-y: auto;
    }
</style>
<div id="technicianReminder" class="reminder-modal">
    <div class="reminder-container">
        <div class="modal-header reminder-header">
            <img src="{{ asset('img/online-ticket.gif') }}" alt="ticket" class="ticket-gif">
            <h3 class="fw-bold ms-2 text-white mt-2">Welcome back!</h3>
        </div>
        <div class="modal-body reminders-content">
            <h5 class="fw-bold">Ticket Reminders</h5>
            <p>There are <strong class="text-primary">{{ count($tickets) }} tickets</strong> that are unresolved:</p>
            @if(count($tickets) != 0)
            <ol class="list-group list-group-numbered ticket-list n-mt-2">
                @foreach ($tickets as $ticket)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto d-flex flex-column flex-wrap">
                        <small class="fw-bold">
                            <span class="text-logo-dark">#{{ $ticket->id }}</span>
                            {{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}
                        </small>
                        <small class="n-mt-1">
                            {{ $ticket->ticketNature->ticket_nature_name }}
                        </small>
                    </div>
                    <span class="badge text-bg-primary rounded-pill">{{ $ticket->status->status_name }}</span>
                </li>
                @endforeach
            </ol>
            <p class="mt-3">Please review these tickets and take appropriate actions.</p>
            @endif
            <hr>
            <button type="button" class="close-button btn bg-warning-subtle fw-bold border-2 border-warning">
                Close
            </button>
        </div>
    </div>
</div>