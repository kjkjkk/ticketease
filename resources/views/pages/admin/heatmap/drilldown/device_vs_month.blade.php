@extends('layouts.master')
@section('title', 'TicketEase | Heatmap')
@section('nav-title', 'Heatmap')
@section('content')
<div class="p-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.heatmap') }}" class="fw-bold text-primary text-decoration-underline">
                    Heatmap
                </a>
            </li>
            <li class="breadcrumb-item " aria-current="page">
                <a href="{{ url()->previous() }}" class="fw-bold text-primary text-decoration-underline">
                    Devices&nbsp;VS&nbsp;Months
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $device . ' / ' . $month }}
            </li>
        </ol>
    </nav>
    <div class="col-12 col-lg-10 col-xl-8 m-auto">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="fw-bold mt-2">{{ $device . '/' . $month }}</h6>
                <a href="{{ url()->previous() }}" class="btn btn-primary fw-semibold btn-sm"><i
                        class="fi fi-ss-hand-back-point-left me-1"></i>Go back</a>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-12 col-lg-5 my-auto">
                        <h5 class="fw-bold mb-3">Total: {{ $totalTickets . " tickets"}}</h5>
                        <div class="d-flex flex-column">
                            @foreach ($data as $row)
                            <div class="col-12 fw-semibold d-flex justify-content-between border-bottom border-2 mb-2">
                                <span>{{ $row->ticketNature->ticket_nature_name . " ($row->count)" }}</span>
                                <span class="text-logo-dark">{{ $row->percentage . "%" }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-8 col-lg-7 mx-auto">
                        <canvas id="technicianTickets"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/cus/heatmap-link-active.js'])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('technicianTickets').getContext('2d');
        var technicianNames = @json($techData->pluck('lastname'));
        var ticketCounts = @json($techData->pluck('count'));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: technicianNames,  // Use technician's last names for labels
                datasets: [{
                    data: ticketCounts,  // Ticket count for each technician
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Tickets by Technician'
                    },
                    tooltip: {
                        callbacks: {
                            // This function will display the technician's last name along with the count
                            label: function(tooltipItem) {
                                let label = technicianNames[tooltipItem.dataIndex] || '';  // Get the technician's lastname
                                let value = ticketCounts[tooltipItem.dataIndex];  // Get the ticket count
                                return label + ': ' + value + ' tickets';  // Custom tooltip message
                            }
                        }
                    }
                },
                hover: {
                    onHover: function(event, chartElement) {
                        // Change cursor to pointer when hovering over a chart element
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            }
        });
    });
</script>
@endsection