<div class="bg-warning-subtle px-3 py-4 rounded" style="max-width: 400px; outline: 2px solid #bbb;">
    <div class="ticket-row">
        <span class="fw-semibold">FACILITY:</span>
        {{-- {{ $ticket->district->district_name }} --}}
    </div>
    <div class="ticket-row">
        <span class="fw-semibold">NAME:</span>
        {{-- {{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }} --}}
    </div>
    <div class="ticket-row">
        <span class="fw-semibold">DATE RECEIVED:</span>
        {{-- {{ $ticket->created_at->format('F j, Y g:i a') }} --}}
    </div>
    <div class="ticket-row">
        <span class="fw-semibold">ASSIGNED TO:</span>
        {{-- {{ $ticket->ticketAssign->user->firstname . ' ' . $ticket->ticketAssign->user->lastname }} --}}
    </div>
    <div class="ticket-row bg-danger fw-bold text-center text-white py-1">
        ICT TMS TICKET STUB 2024
    </div>
    <div class="ticket-row bg-danger fw-bold text-center text-white py-2">
        {{-- {{ $ticket->id }} --}}
    </div>
    <div class="ticket-row">
        <span class="fw-semibold">DATE ASSIGNED:</span>
        {{-- {{ $ticket->ticketAssign->date_assigned }} --}}
    </div>
    <div class="ticket-row">
        <span class="fw-semibold">ASSIGNED BY:</span>
        {{-- {{ $ticket->ticketAssign->user->firstname . ' ' .$ticket->ticketAssign->user->lastname }} --}}
    </div>
    <div class="ticket-row text-center">-----------------------------------------</div>
</div>