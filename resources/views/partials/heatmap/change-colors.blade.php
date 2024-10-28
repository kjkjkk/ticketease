<div class="col-12 p-3">
    <div class="d-flex flex-column mb-3">
        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($default_palette as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="default" wire:model="selectedPalette"
                wire:click="selectPalette('default')" style="width: 20px; height: 20px;" {{ $selectedPalette=='default'
                ? 'checked' : '' }}>
        </div>
        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($palette_one as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="palette_one" wire:model="selectedPalette"
                wire:click="selectPalette('palette_one')" style="width: 20px; height: 20px;" {{
                $selectedPalette=='palette_one' ? 'checked' : '' }}>
        </div>

        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($palette_two as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="palette_two" wire:model="selectedPalette"
                wire:click="selectPalette('palette_two')" style="width: 20px; height: 20px;" {{
                $selectedPalette=='palette_two' ? 'checked' : '' }}>
        </div>

        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($palette_three as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="palette_three" wire:model="selectedPalette"
                wire:click="selectPalette('palette_three')" style="width: 20px; height: 20px;" {{
                $selectedPalette=='palette_three' ? 'checked' : '' }}>
        </div>

        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($palette_four as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="palette_four" wire:model="selectedPalette"
                wire:click="selectPalette('palette_four')" style="width: 20px; height: 20px;" {{
                $selectedPalette=='palette_four' ? 'checked' : '' }}>
        </div>
        <div class="d-flex align-items-center gap-1 mb-1">
            @foreach ($palette_five as $color)
            <div class="border border-2 border-dark rounded"
                style="width: 20px; height: 20px; background-color: {{ $color }};"></div>
            @endforeach
            <input type="radio" name="palette" value="palette_five" wire:model="selectedPalette"
                wire:click="selectPalette('palette_five')" style="width: 20px; height: 20px;" {{
                $selectedPalette=='palette_five' ? 'checked' : '' }}>
        </div>
    </div>

    <div class="mb-2">
        <h6 class="fw-bold">Mininum & maximum values</h6>
        <div style="display: flex; align-items: center;">
            <div style="width: 50px; height: 20px; background-color: {{ $this->getHeatmapColor($minValue, $minValue, $maxValue) }};"
                class="border border-2 border-dark rounded">
            </div>
            <span style="margin-left: 10px;">Min: <span class="fw-bold">{{ $minValue }}</span></span>
        </div>
        <div style="display: flex; align-items: center;">
            <div style="width: 50px; height: 20px; background-color: {{ $this->getHeatmapColor($maxValue, $minValue, $maxValue) }};"
                class="border border-2 border-dark rounded">
            </div>
            <span style="margin-left: 10px;">Max: <span class="fw-bold">{{ $maxValue }}</span></span>
        </div>
    </div>
</div>