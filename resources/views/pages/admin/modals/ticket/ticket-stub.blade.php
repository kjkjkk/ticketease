<x-modal id="ticketStub" title="Ticket Stub" size="md">
    <x-ticket-stub :ticket="$ticket"></x-ticket-stub>
    <hr>
    <div class="float-end">
        <x-cancel-button>Close</x-cancel-button>
    </div>
</x-modal>