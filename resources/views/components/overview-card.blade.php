<div class="col-12 mx-auto">
    <div class="card p-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
                <h6 class="fw-semibold text-muted small text-uppercase">{{ $title }} Tickets</h6>
                <h2 class="fw-bold text-dark n-mt-2">{{ $result }}</h2> <!-- Display the result -->
            </div>
            <div class="bg-{{ $color }} d-flex justify-content-center align-items-center border border-{{ $color }} border-3"
                style="height: 50px; width: 50px; border-radius: 50%;">
                <div style="font-size: 1.5rem;" class="mt-1 text-white">{{ $slot }}</div>
            </div>
        </div>
    </div>
</div>