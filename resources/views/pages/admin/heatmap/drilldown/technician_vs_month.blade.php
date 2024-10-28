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
                    Technician&nbsp;VS&nbsp;Months
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ 'Tech. ' . $technician . ' / ' . 'Month of ' . $month }}
            </li>
        </ol>
    </nav>
    <div class="col-12 col-lg-10 col-xl-8 m-auto">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="fw-bold mt-2">{{ 'Tech. ' . $technician . ' / ' . 'Month of ' . $month }}</h6>
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
                                <span>{{ $row->ticket_nature_name . " ($row->count)" }}</span>
                                <span class="text-logo-dark">{{ $row->percentage . "%" }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-10 col-md-8 col-lg-7 mx-auto">
                        <canvas id="districtTickets" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/cus/heatmap-link-active.js'])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('districtTickets').getContext('2d');
        var districtNames = @json($districtData->pluck('district_name'));
        var ticketCounts = @json($districtData->pluck('count'));

        new Chart(ctx, {
            type: 'bar',  // Changed to 'bar'
            data: {
                labels: districtNames,  // District names for the x-axis
                datasets: [{
                    data: ticketCounts,  // Ticket count for each district
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;

                        if (!chartArea) {
                            // Avoid errors if chart has not been fully rendered
                            return null;
                        }

                        const gradient = ctx.createLinearGradient(
                            0,
                            chartArea.top,
                            0,
                            chartArea.bottom
                        );
                        gradient.addColorStop(0, "#28a745");  // Start color (green)
                        gradient.addColorStop(1, "#81c784");  // End color (lighter green)

                        return gradient;
                    },
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,  // No legend for a single dataset in a bar chart
                    },
                    title: {
                        display: true,
                        text: 'Tickets by Districts'  // Title of the chart
                    },
                    tooltip: {
                        callbacks: {
                            // Tooltip showing technician's name and ticket count
                            label: function(tooltipItem) {
                                let label = districtNames[tooltipItem.dataIndex] || '';  // Get the district name
                                let value = ticketCounts[tooltipItem.dataIndex];  // Get the ticket count
                                return label + ': ' + value + ' tickets';  // Custom tooltip message
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,  // Ensure x-axis starts from zero
                    },
                    y: {
                        beginAtZero: true,  // Ensure y-axis starts from zero
                        ticks: {
                            stepSize: 1  // Ticket count in whole numbers
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