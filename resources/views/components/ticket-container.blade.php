<div class="card border rounded shadow-sm border-2 border-success">
    <div class="d-flex p-2">
        <div class="col-10 p-0">
            <div class="row m-0 p-0 d-flex align-items-center">
                <div class="col-auto p-0 d-flex">
                    <p class="mb-0 fw-bold text-logo-dark">{{ $ticketNum }}</p>

                    <small class="fw-semibold ms-1">{{ \Carbon\Carbon::parse($assignedTime) }}</small>
                </div>
            </div>
            <div class="row p-0 d-flex align-items-start mb-2">
                <p class="mb-0 fw-bold n-mt-1">{{ $ticketNature }}</p>
                <small class="font-sm fw-semibold n-mt-1">({{ Str::limit($district, 18) }})</small>
                <small>{{ Str::limit($details, 18) }}</small>
            </div>
            <div class="row p-0 d-flex align-items-start n-mt-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#viewTicketDetails-{{$viewModal}}"
                    class="fw-bold text-logo-dark font-sm">View Details</a>
            </div>
        </div>
        <div class="col-2 p-0 m-0 d-flex justify-content-center align-items-center">
            <button class="btn btn-outline-success text-logo-dark" data-bs-toggle="modal"
                data-bs-target="#createSchedule-{{$createSched ?? null}}"><i class="fi fi-ss-ticket fs-3"></i></button>
        </div>
    </div>
</div>