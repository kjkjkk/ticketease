@extends('layouts.master')
@section('title', 'TicketEase | Manage User')
@section('nav-title', 'Manage Users')
@section('content')
<div class="p-4">
    <div class="">
        <div class="bg-white rounded shadow-sm">
            <div class="row p-3 d-flex align-items-center rounded">
                <div class="col-sm-12 col-md-6 col-xl-3 mb-2">
                    <small class="fw-semibold">Search by user ID</small>
                    <form action="{{ route('shared.manage-users') }}" method="GET" class="d-flex">
                        <input type="text" class="form-control border-2 border-success" placeholder="Enter ID"
                            name="userID" autocomplete="off" value="{{ request('userID') }}">
                        <button type="submit" class="btn btn-success ms-1"><i
                                class="fi fi-ss-member-search"></i></button>
                    </form>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4 mb-2">
                    <small class="fw-semibold">Search user name</small>
                    <form action="{{ route('shared.manage-users') }}" method="GET" class="d-flex">
                        <input type="hidden" name="role" value="{{ request('role') }}">
                        <input type="text" class="form-control border-2 border-success"
                            placeholder="Enter firstname or lastname" name="searchUser" autocomplete="off"
                            value="{{ request('searchUser') }}">
                        <button type="submit" class="btn btn-success ms-1"><i
                                class="fi fi-ss-member-search"></i></button>
                    </form>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-3 mb-2">
                    <small class="fw-semibold">Filter by roles</small>
                    <x-dropdown title="{{ request('role') ? request('role') : 'All'  }}"
                        route="{{ route('shared.manage-users') }}">
                        @foreach ($roles as $item)
                        <a class="dropdown-item text-truncate"
                            href="{{ route('shared.manage-users', ['role' => $item]) }}">
                            {{ $item }}
                        </a>
                        @endforeach
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
    <!-- User Table -->
    <div class="table-responsive mt-3 rounded bg-white border p-3">
        <div class="d-flex justify-content-end gap-2 flex-wrap ">
            @if(!auth()->user()->is_temporary_admin && auth()->user()->role === "Admin")
            <button class="btn btn-primary float-end d-flex px-3 mb-3" data-bs-toggle="modal"
                data-bs-target="#assignAsTemporaryAdmin">
                <i class="fi fi-ss-user-add"></i>
                <span class="ms-2 fw-semibold d-sm-block ">ASSIGN TEMPORARY ADMIN</span>
            </button>
            @endif
            <button class="btn btn-success float-end d-flex px-3 mb-3" data-bs-toggle="modal"
                data-bs-target="#createUser">
                <i class="fi fi-ss-user-add"></i>
                <span class="ms-2 fw-semibold d-sm-block ">ADD NEW USER</span>
            </button>
        </div>
        <table class="table table-bordered user-table">
            <thead class="table-logo-dark">
                <tr>
                    @foreach (['ID', 'Name', 'Role', 'Username', 'Email', 'Status'] as $header)
                    <th>{{ $header }}</th>
                    @endforeach
                    <th class="text-center"><i class="fi fi-ss-settings-sliders"></i></th>
                </tr>
            </thead>
            <tbody>
                @if($users->isEmpty())
                <tr>
                    <td colspan="7" class="text-center fw-semibold py-3">
                        <h6>--- NO USER FOUND ---</h6>
                    </td>
                </tr>
                @else
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        {{ $user->firstname . ' ' . $user->lastname }}
                    </td>
                    <td>
                        @php
                        $color = match($user->role){
                        'Admin' => 'indi',
                        'Technician' => 'primary',
                        'Requestor' => 'info',
                        };
                        @endphp
                        <x-user-role :color="$color">
                            {{ $user->is_temporary_admin ? "Temporary " . $user->role : $user->role }}
                        </x-user-role>
                    </td>
                    <td>{{ $user->username }}</td>
                    <td>
                        @if($user->email && $user->email_verified_at)
                        {{ $user->email }}
                        @else
                        <span class="text-danger fw-bold">
                            Not Verified
                        </span>
                        @endif
                    </td>
                    <td>
                        @php
                        $color = match($user->user_status) {
                        'Active' => 'success',
                        'Inactive' => 'danger',
                        };
                        @endphp
                        <x-user-status :color="$color">
                            {{ $user->user_status }}
                        </x-user-status>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            @if($user->role != "Admin")
                            <a class="btn" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fi fi-ss-menu-dots fs-5"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                @if(auth()->user()->role != $user->role)
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resetPassword"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->firstname . ' ' . $user->lastname }}">
                                        Reset Password
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#userStatus"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->firstname . ' ' . $user->lastname }}"
                                        data-status="{{ $user->user_status }}">
                                        {{ $user->user_status === 'Active' ? 'Deactivate User' : 'Reactivate User'}}
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteUser"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->firstname . ' ' . $user->lastname }}">Delete
                                    </button>
                                </li>
                                @endif
                            </ul>
                            @elseif($user->role === "Admin" && $user->is_temporary_admin)
                            <div class="dropdown">
                                <a class="btn" href="#" role="button" id="cancelTemporaryAdmin"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fi fi-ss-menu-dots fs-5"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="cancelTemporaryAdmin">
                                    @if(!auth()->user()->is_temporary_admin && auth()->user()->role === "Admin")
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#cancelTemporaryAdminRole" data-techID="{{ $user->id }}"
                                            data-techName="{{ $user->firstname . ' ' . $user->lastname }}">
                                            Cancel Temporary Role
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="p-1">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
    @if($users->isNotEmpty())
    @include('pages.admin.modals.user.create')
    @include('pages.admin.modals.user.reset-password')
    @include('pages.admin.modals.user.status-update')
    @include('pages.admin.modals.user.delete')
    @include('pages.admin.modals.user.temporary-admin')
    @include('pages.admin.modals.user.cancel-temporary-admin')
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            toggleSignatureField();
            // Reset Password
            const resetPasswordModal = document.getElementById('resetPassword');

            resetPasswordModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');

                const inputUserId = document.getElementById('resetPasswordUserId');
                const displayUserName = document.getElementById('resetPasswordUserName');

                inputUserId.value = userId;
                displayUserName.textContent = userName;
            });

            // User Status Toggle (Deactivate / Reactivate)
            const updateStatusModal = document.getElementById('userStatus');

            updateStatusModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');
                const userStatus = button.getAttribute('data-status');
                
                const inputUserId = document.getElementById('userStatusUserId');
                const spanUserName = document.getElementById('updateStatusUserName');
                const accountStatus = document.getElementById('accountStatus');
                const accountState = document.getElementById('accountState');
                
                inputUserId.value = userId;
                spanUserName.textContent = userName;
                accountStatus.textContent = userStatus === 'Active' ? 'deactivate' : 'reactivate';
                accountState.textContent = userStatus === 'Active' ? 'suspended' : 'restored';
            });

            // Delete User (Can only delete if it does not violate the constraint)
            const deleteUserModal = document.getElementById('deleteUser');

            deleteUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');

                const inputUserId = document.getElementById('deleteUserId');
                const spanUserName = document.getElementById('deleteUserName');

                inputUserId.value = userId;
                spanUserName.textContent = userName;
            });

            const cancelTemporaryAdminModal = document.getElementById('cancelTemporaryAdminRole');
            
            cancelTemporaryAdminModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const techID = button.getAttribute('data-techID');
                const techName = button.getAttribute('data-techName');
                
                const inputTechId = document.getElementById('temporaryAdminID'); // Fixed typo here
                const spanTechName = document.getElementById('temporaryAdminName'); // Fixed typo here
                
                inputTechId.value = techID;
                spanTechName.textContent = techName;
            }); 

        });
        //admin/modals/add-new-user.blade.php: this function disables file input field when the role chosen is requestor
        function toggleSignatureField() {
            var role = document.getElementById("role").value;
            var signatureInput = document.getElementById("signature");

            if (role === "Requestor") {
                signatureInput.disabled = true;
                signatureInput.value = "";
            } else {
                signatureInput.disabled = false;
            }
        }
    </script>
</div>
@endsection