<select name="technician_id" id="technician_id" class="form-control">
    <option value="" selected disabled>Select Technician</option>
    @foreach ($technicians as $tech)
    <option value="{{ $tech->id }}">{{ $tech->firstname . ' ' . $tech->lastname }}</option>
    @endforeach
</select>