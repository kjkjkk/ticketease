<div class="container-fluid">
    <div class="row">
        <h4 class="fw-bold text-logo-dark">Ticket Natures</h4>
        <div class="col-12 col-lg-6 mb-3">
            <div class="col-12 mb-3">
                <small class="fw-semibold">SEARCH TICKET NATURE</small>
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <form wire:submit.prevent='search'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="searchTerm"
                                    placeholder="Search by ticket nature name">
                                <button type="submit" class="btn btn-success">
                                    <i class="fi fi-ss-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-8 mb-col-md-6 col-xl-4">
                        <button class="btn btn-success fw-semibold form-control" data-bs-toggle="modal"
                            data-bs-target="#toggleTicketNature"><i class="fi fi-ss-ticket me-1"></i>ADD</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 300px;">
                <table class="table table-bordered table-hover">
                    <thead style="position: sticky; top: 0;">
                        <tr class="border border-2">
                            <th>Name</th>
                            <th>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticket_natures as $ticket_nature)
                        <tr wire:click='display({{ $ticket_nature->id }})' style="cursor: pointer;">
                            <td>{{ $ticket_nature->ticket_nature_name }}</td>
                            <td>
                                <small class="fw-bold text-{{ $ticket_nature->status === 1 ? 'success' : 'danger' }}">
                                    {{ $ticket_nature->status === 1 ? 'ACTIVE' : 'INACTIVE' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <h6 class="mt-3 fw-semibold">TICKET NATURE DETAILS</h6>
            <x-alert-message />
            <div class="row">
                <input type="hidden" name="id" wire:model='ticket_nature_id'>
                <div class="col-12 mb-2">
                    <small class="fw-semibold">Ticket nature name:</small>
                    <input wire:model='ticket_nature_name' name="ticket_nature_name" type="text" class="form-control">
                    @error('ticket_nature_name')
                    <small class="fw-semibold text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12 mb-2">
                    <small class="fw-semibold">Created at:</small>
                    <input wire:model='created_at' type="text" class="form-control" disabled>
                </div>
                <div class="col-12 mb-2">
                    <small class="fw-semibold">Updated at:</small>
                    <input wire:model='updated_at' type="text" class="form-control" disabled>
                </div>
                <div class="d-flex justify-content-end my-3 gap-2">
                    <button wire:click='clear' type="button" class="btn btn-sm btn-warning fw-semibold"><i
                            class="fi fi-ss-broom me-1"></i>Clear</button>
                    <button wire:click='delete' type="button" class="btn btn-sm btn-danger fw-semibold"><i
                            class="fi fi-ss-trash me-1"></i>Delete</button>
                    <button wire:click='update' type="button" class="btn btn-sm btn-primary fw-semibold"><i
                            class="fi fi-ss-customize-edit me-1"></i>Update</button>
                </div>
            </div>
            <div class="col-12 mb-3 rounded d-flex justify-content-between align-items-center p-2"
                style="outline: 2px solid var(--bs-logo-dark)">
                <h6 class="fw-semibold">Status: <span class="text-{{ $status === 1 ? 'success' : 'danger' }}">
                        @if($status === 1)
                        Active
                        @elseif($status === 0)
                        Inactive
                        @endif
                    </span>
                </h6>
                <button wire:click='toggleStatus' class="btn btn-success fw-semibold">
                    <i class="fi fi-ss-convert-shapes me-2"></i>Toggle
                </button>
            </div>
        </div>
    </div>
    <x-modal id="toggleTicketNature" title="Add new ticket nature" size="sm">
        <form wire:submit.prevent='create'>
            <div class="row">
                <div class="col-12 mb-3">
                    <small class="fw-semibold">ENTER NEW TICKET NATURE NAME:</small>
                    <input wire:model='new_ticket_nature' type="text" class="form-control" required>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <x-cancel-button>Cancel</x-cancel-button>
                    <button type="submit" class="btn btn-logo" data-bs-dismiss="modal">Confirm</button>
                </div>
            </div>
        </form>
    </x-modal>
</div>