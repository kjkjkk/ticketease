<div class="container-fluid">
    <div class="row">
        <h4 class="fw-bold text-logo-dark">Districts</h4>
        <div class="col-12 col-lg-6 mb-3">
            <div class="col-12 mb-3">
                <small class="fw-semibold">SEARCH DISTRICT</small>
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <form wire:submit.prevent='search'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="searchTerm"
                                    placeholder="Search by device name">
                                <button type="submit" class="btn btn-success">
                                    <i class="fi fi-ss-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-8 col-md-6 col-xl-4">
                        <button class="btn btn-success  fw-semibold form-control" data-bs-toggle="modal"
                            data-bs-target="#toggleDistrict"><i class="fi fi-ss-building me-1"></i>ADD</button>
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
                        @foreach ($districts as $district)
                        <tr wire:click='display({{ $district->id }})' style="cursor: pointer;">
                            <td>{{ $district->district_name }}</td>
                            <td>
                                <small class="fw-bold text-{{ $district->status === 1 ? 'success' : 'danger' }}">
                                    {{ $district->status === 1 ? 'ACTIVE' : 'INACTIVE' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <h6 class="mt-3 fw-semibold">DISTRICT DETAILS</h6>
            <x-alert-message />
            <div class="row">
                <input type="hidden" name="id" wire:model='district_id'>
                <div class="col-12 mb-2">
                    <small class="fw-semibold">District name:</small>
                    <input wire:model='district_name' name="district_name" type="text" class="form-control">
                    @error('district_name')
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
                {{-- data-bs-toggle="modal" data-bs-target="#toggleDevice" --}}
                <button wire:click='toggleStatus' class="btn btn-success fw-semibold">
                    <i class="fi fi-ss-convert-shapes me-2"></i>Toggle
                </button>
            </div>
        </div>
    </div>
    <x-modal id="toggleDistrict" title="Add new district" size="sm">
        <form wire:submit.prevent='create'>
            <div class="row">
                <div class="col-12 mb-3">
                    <small class="fw-semibold">ENTER NEW DISTRICT NAME:</small>
                    <input wire:model='new_district' type="text" class="form-control" required>
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