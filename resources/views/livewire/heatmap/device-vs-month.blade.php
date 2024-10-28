<div class="row">
    @include('partials.heatmap.sliding-panel')
    <div class="col-12">
        <div class="card table-responsive shadow-sm">
            <table class="table">

                <thead>
                    <tr>
                        <th class="d-flex align-items-center" style="pointer-events: none;">
                            {{ $selectedYear }}
                        </th>

                        @foreach ($columns as $column)
                        <th class="heatmap-head" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip" data-bs-title="{{ $column }}">{{
                            substr($column, 0, 3) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $rowData)
                    @php
                    $device = $rowData['device_name']
                    @endphp
                    <tr>
                        <td class="heatmap-head heatmap-label">
                            <small class="fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip" data-bs-title="{{ $rowData[$key] }}">
                                {{ substr($rowData[$key], 0, 9) }}
                            </small>
                        </td>
                        @foreach (array_slice($rowData, 1) as $month => $volume)
                        <td class="heatmap-cell" style="background-color: {{ $this->getHeatmapColor($volume, $minValue, $maxValue) }};
                                    border-color: {{ $this->getHeatmapColor($volume, $minValue, $maxValue) }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{ $rowData[$key] . ' / ' . $month  . ' (' . $volume . ')'}}">
                            <a
                                href="{{ route('admin.heatmap.drilldown.device-vs-month', [$device, $month, $selectedYear]) }}">
                                <div style="width: 100%; height: 100%;">
                                    @if ($showVolume)
                                    <span id="displayVolume">
                                        {{ $volume }}
                                    </span>
                                    @else
                                    <span style="display: inline-block; width: 100%; height: 100%;"></span>
                                    <!-- Keep clickable area -->
                                    @endif
                                </div>
                            </a>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('th').click(function() {
                var columnIndex = $(this).index();

                // Toggle visibility of all <td> elements in the same column
                $('table tr').each(function() {
                    $(this).find('td').eq(columnIndex).toggle();
                });

                // Optionally, toggle the <th> visibility too
                $(this).toggle();
            });
            $('.heatmap-label').click(function() {
            // Hide the entire row containing the clicked <td>
                $(this).closest('tr').hide();
            });
        });
    </script>
</div>