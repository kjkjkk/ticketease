<div class="tickets-wrapper bg-white">
    <button class="sliding-panel-toggle" type="button" style="z-index: 2;">
        <span class="material-icons sp-icon-open px-2"><i class="fi fi-ss-settings-sliders"></i></span>
        <span class="material-icons sp-icon-close px-2"><i class="fi fi-ss-circle-xmark"></i></span>
    </button>
    <div class="sliding-panel">
        <div class="tickets-container bg-light rounded pt-3">
            <h5 class="fw-semibold mb-3 d-flex align-items-center">
                <i class="fi fi-ss-sensor-fire ms-3 me-1"></i>Customize Heatmap
            </h5>
            <hr>
            <div class="card m-3 p-3 border border-white">
                <span class="fw-semibold border-bottom" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Choose a color combination for the heatmap."><i
                        class="fi fi-ss-palette me-2"></i>Color Combinations</span>

                @include('partials.heatmap.change-colors')
                <div class="mt-3">
                    <input type="checkbox" wire:model="showVolume" id="showVolumeCheckbox"
                        style="accent-color: yellow; width: 32px; height: 32px;" class="me-2" hidden>
                    <button wire:click="$toggle('showVolume')"
                        class="btn btn-{{ $showVolume ? 'logo' : 'outline-dark border-2' }} btn-sm fw-bold form-control"
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-title="This will toggle the visibility of the volumes.">
                        {{ $showVolume ? 'Hide volumes' : 'Show volumes' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector(".sliding-panel-toggle").addEventListener("click", () => {
        document.querySelector(".tickets-wrapper").classList.toggle("sliding-panel-open");
    });
</script>