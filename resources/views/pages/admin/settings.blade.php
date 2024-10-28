@extends('layouts.master')
@section('title', 'TicketEase | Settings')
@section('nav-title', 'Settings')
@section('content')
<div class="container-fluid p-4">
    <div class="card shadow-sm p-4">
        <div class="row h-100">
            <div class="col-12 col-xl-3">
                <ul class="settings d-flex flex-xl-column mt-4">
                    <li class="settings-nav active" id="devices" onclick="toggleContainers('device')">
                        Devices
                    </li>
                    <li class="settings-nav " id="districts" onclick="toggleContainers('district')">
                        Districts
                    </li>
                    <li class="settings-nav" id="ticketNatures" onclick="toggleContainers('ticket-nature')">
                        Ticket Natures
                    </li>
                </ul>
            </div>
            <!-- Livewire Content -->
            <div class="col-12 col-xl-9 p-4" style="height: 100%; overflow-y: auto;">
                <div id="devices-container" class="d-block">
                    @livewire('devices')
                </div>
                <div id="districts-container" class="d-none">
                    @livewire('districts')
                </div>
                <div id="ticket-natures-container" class="d-none">
                    @livewire('ticket-natures')
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleContainers(container) {
        const devicesClick = document.getElementById('devices');
        const districtsClick = document.getElementById('districts');
        const ticketNaturesClick = document.getElementById('ticketNatures');

        const devicesContainer = document.getElementById('devices-container');
        const districtsContainer = document.getElementById('districts-container');
        const ticketNaturesContainer = document.getElementById('ticket-natures-container');
        
        if (container === 'device') {
            // Toggle the container visibility
            devicesContainer.classList.remove('d-none');
            devicesContainer.classList.add('d-block');

            districtsContainer.classList.remove('d-block');
            districtsContainer.classList.add('d-none');
            
            ticketNaturesContainer.classList.remove('d-block');
            ticketNaturesContainer.classList.add('d-none');
            // Toggle the list active class
            devicesClick.classList.add('active');
            districtsClick.classList.remove('active');
            ticketNaturesClick.classList.remove('active');
        } else if (container === 'district') {
            // Toggle the container visibility
            districtsContainer.classList.remove('d-none');
            districtsContainer.classList.add('d-block');

            devicesContainer.classList.remove('d-block');
            devicesContainer.classList.add('d-none');

            ticketNaturesContainer.classList.remove('d-block');
            ticketNaturesContainer.classList.add('d-none');
            // Toggle the list active class
            districtsClick.classList.add('active');
            devicesClick.classList.remove('active');
            ticketNaturesClick.classList.remove('active');
        } else if (container === 'ticket-nature') {
            // Toggle the container visibility
            ticketNaturesContainer.classList.remove('d-none');
            ticketNaturesContainer.classList.add('d-block');

            districtsContainer.classList.remove('d-block');
            districtsContainer.classList.add('d-none');
            
            devicesContainer.classList.remove('d-block');
            devicesContainer.classList.add('d-none');
            // Toggle the list active class
            ticketNaturesClick.classList.add('active');
            districtsClick.classList.remove('active');
            devicesClick.classList.remove('active');
        }
    }
</script>
@endsection