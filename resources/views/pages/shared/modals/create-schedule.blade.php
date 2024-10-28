<x-modal id="createSchedule-{{$ticket->ticket->id}}" title="Create Schedule for Ticket" size="md">
    <div class="row fw-bold">
        <div class="col-4">
            <p>Ticket <span class="fw-normal">#{{$ticket->ticket->id}}</span></p>
        </div>
        <div class="col-8">
            <p>Date Assigned:
                <span class="fw-normal">
                    @if($ticket->ticket->ticketAssign && $ticket->ticket->ticketAssign->date_assigned)
                    {{ \Carbon\Carbon::parse($ticket->ticket->ticketAssign->date_assigned)->format('F j, Y g:i A') }}
                    @else
                    Not Assigned
                    @endif
                </span>
            </p>
        </div>
    </div>
    <div class="row fw-bold">
        <div class="col-4">
            <p>Type: <span class="fw-normal">{{optional($ticket->ticket->ticketNature)->ticket_nature_name }}</span></p>
        </div>
        <div class="col-8">
            <p>District: <span class="fw-normal">{{optional($ticket->ticket->district)->district_name}}</span></p>
        </div>
    </div>
    <div class="row fw-bold mb-3">
        <div class="col-4">
            <p>Department: <span class="fw-normal">{{optional($ticket->ticket)->department}}</span></p>
        </div>
        <div class="col-8">
            <p>Date Submitted: <span class="fw-normal">{{\Carbon\Carbon::parse($ticket->created_at)->format('F j, Y g:i
                    A')}}</span></p>
        </div>
    </div>

    <form action="{{ route('shared.calendar.store') }}" method="POST">
        @csrf

        <input type="hidden" name="ticket_assign_id" value="{{optional($ticket->ticket->ticketAssign)->id}}">

        <div class="mb-3">
            <label for="start_time_{{$ticket->ticket->id}}" class="fw-bold">Start Time</label>
            <input type="datetime-local" class="form-control bg-white" name="start_time"
                id="start_time_{{$ticket->ticket->id}}" required>
        </div>

        <div class="mb-3">
            <label for="end_time_{{$ticket->ticket->id}}" class="fw-bold">Estimated Finish Time</label>
            <input type="datetime-local" class="form-control bg-white" name="end_time"
                id="end_time_{{$ticket->ticket->id}}" required>
        </div>


        <div class="mb-3">
            <label for="comments" class="fw-bold">Comments</label>
            <textarea name="comments" class="form-control bg-white" required></textarea>
        </div>

        <hr>
        <div class="float-end">
            <x-cancel-button>Close</x-cancel-button>
            <x-submit-button>Create Schedule</x-submit-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all elements with IDs that start with "createSchedule-"
            const modals = document.querySelectorAll('[id^="createSchedule-"]');

            // Loop through each modal found
            modals.forEach(modal => {
                // Extract the ticket ID from the modal's ID
                const ticketId = modal.id.split('-')[1];
                const startTimeInput = document.getElementById('start_time_' + ticketId);
                const endTimeInput = document.getElementById('end_time_' + ticketId);

                if (startTimeInput && endTimeInput) {
                    startTimeInput.addEventListener('change', function() {
                        endTimeInput.min = startTimeInput.value;
                    });
                }
            });
        });
    </script>
</x-modal>