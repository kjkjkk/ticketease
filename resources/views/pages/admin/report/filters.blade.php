<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed fw-bold border border-2 border-secodary" type="button"
                data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                aria-controls="flush-collapseTwo">
                <i class="fi fi-ss-filter me-1"></i>Filter by ticket nature
            </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body" style="max-height: 400px; overflow-y: auto;">
                @foreach ($ticketNatures as $ticketNature)
                <div class="border border-2 px-2 py-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $ticketNature->ticket_nature_name }}"
                            id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            {{ $ticketNature->ticket_nature_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed fw-bold border border-2 border-secodary" type="button"
                data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false"
                aria-controls="flush-collapseThree">
                <i class="fi fi-ss-filter me-1"></i>Filter by districts
            </button>
        </h2>
        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body" style="max-height: 400px; overflow-y: auto;">
                @foreach ($districts as $district)
                <div class="border border-2 px-2 py-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $district->district_name }}"
                            id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            {{ $district->district_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>