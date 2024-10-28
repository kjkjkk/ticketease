<div class="d-flex justify-content-center align-center flex-column">
    <div class="row">
        @foreach ($steps as $step)
        @php
        // Determine if the current step is active
        $isActive = $currentStep >= $step['step'];

        // Get the minimum ID for formatting the date for multi-ID steps
        $statusId = is_array($step['id']) ? min($step['id']) : $step['id'];

        // Format the date using the provided callback
        $date = $formatDate($statusId);
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <small class="text-center fw-semibold">{{ $date }}</small>
            <div class="progress-step {{ $isActive ? 'active' : '' }}">
                <div class="progress-bar w-100 {{ $isActive ? 'active' : '' }}" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100"></div>

                <div class="d-flex mt-2 align-center">
                    <span class="progress-mark mr-2"></span>
                    <span class="progress-label">
                        {{ $step['label'] }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>