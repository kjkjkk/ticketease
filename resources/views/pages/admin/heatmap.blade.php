@extends('layouts.master')
@section('title', 'TicketEase | Heatmap')
@section('nav-title', 'Heatmap')
@section('content')
<div class="p-4">
    <div class="card">
        <div class="card-header bg-white p-0">
            <ul class="heatmap-ul d-flex my-2">
                <li class="heatmap-nav active" id="district_vs_month"
                    onclick="toggleContainers('districts_months_container')">
                    Districts vs Months
                </li>
                <li class="heatmap-nav" id="technician_vs_month"
                    onclick="toggleContainers('technician_months_container')">
                    Technicians vs Months
                </li>
                <li class="heatmap-nav" id="technician_vs_devices"
                    onclick="toggleContainers('technician_districts_container')">
                    Devices vs Months
                </li>
            </ul>
        </div>
        <div class="card-body p-3w bg-secondary-subtle">
            <div id="districts_months_container" class="d-block">
                @include('pages.admin.tabs.district_vs_month')
            </div>
            <div id="technician_months_container" class="d-none">
                @include('pages.admin.tabs.technician_vs_month')
            </div>
            <div id="technician_districts_container" class="d-none">
                @include('pages.admin.tabs.device_vs_month')
            </div>
        </div>
    </div>
</div>
<script>
    function toggleContainers(container) {
        const district_vs_month = document.getElementById('district_vs_month');
        const technician_vs_month = document.getElementById('technician_vs_month');
        const technician_vs_devices = document.getElementById('technician_vs_devices');
        const districts_months_container = document.getElementById('districts_months_container');
        const technician_months_container = document.getElementById('technician_months_container');
        const technician_districts_container = document.getElementById('technician_districts_container');
        
        if (container === 'districts_months_container') {
            // Toggle the container visibility
            districts_months_container.classList.remove('d-none');
            districts_months_container.classList.add('d-block');

            technician_months_container.classList.remove('d-block');
            technician_months_container.classList.add('d-none');

            technician_districts_container.classList.remove('d-block');
            technician_districts_container.classList.add('d-none');
            // Toggle the list active class
            district_vs_month.classList.add('active');
            technician_vs_month.classList.remove('active');
            technician_vs_devices.classList.remove('active');
        } else if (container === 'technician_months_container') {
            // Toggle the container visibility
            technician_months_container.classList.remove('d-none');
            technician_months_container.classList.add('d-block');

            districts_months_container.classList.remove('d-block');
            districts_months_container.classList.add('d-none');

            technician_districts_container.classList.remove('d-block');
            technician_districts_container.classList.add('d-none');
            // Toggle the list active class
            technician_vs_month.classList.add('active');
            district_vs_month.classList.remove('active');
            technician_vs_devices.classList.remove('active');
        } else if (container === 'technician_districts_container') {
            // Toggle the container visibility
            technician_districts_container.classList.remove('d-none');
            technician_districts_container.classList.add('d-block');

            technician_months_container.classList.remove('d-block');
            technician_months_container.classList.add('d-none');

            districts_months_container.classList.remove('d-block');
            districts_months_container.classList.add('d-none');
            // Toggle the list active class
            technician_vs_devices.classList.add('active');
            technician_vs_month.classList.remove('active');
            district_vs_month.classList.remove('active');
        }
    }
</script>
@endsection