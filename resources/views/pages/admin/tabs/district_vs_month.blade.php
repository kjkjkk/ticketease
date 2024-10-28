<form action="{{ route('admin.heatmap.district-vs-month') }}">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="fi fi-ss-building me-1"></i>Select Districts
                </div>
                <div class="card-body overflow-y-auto" style="max-height: 20rem;">
                    @foreach ($districts as $district)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="districts[]"
                            value="{{ $district->district_name }}" id="{{ $district->district_name }}" checked>
                        <label class="form-check-label" for="{{ $district->district_name }}">
                            {{ strtoupper($district->district_name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="fi fi-ss-calendar-check me-1"></i>Select Months
                </div>
                <div class="card-body overflow-y-auto" style="max-height: 20rem;">
                    <div class="ms-1">
                        @foreach ($months as $month)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="months[]" value="{{ $month }}"
                                id="{{ $month }}" checked>
                            <label class="form-check-label" for="{{ $month }}">
                                {{ strtoupper($month) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex mt-2">
        <div class="col-12 col-sm-12 col mg-8 col-lg-6 col-xl-5">
            <div class="input-group">
                <span class="input-group-text fw-bold" id="selectYear">
                    Select Year:
                </span>
                <select name="year" id="selectYear" class="form-control" aria-label="year"
                    aria-describedby="selectYear">
                    @foreach ($years as $year)
                    <option value="{{ $year }}">
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary fw-bold">Generate
                    Heatmap</button>
            </div>
        </div>
    </div>
</form>