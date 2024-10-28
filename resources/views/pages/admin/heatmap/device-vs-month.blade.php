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
            <li class="breadcrumb-item active" aria-current="page">
                Device&nbsp;VS&nbsp;Months
            </li>
        </ol>
    </nav>
    @livewire('heatmap.device-vs-month', ['data' => $data, 'selectedYear' => $selectedYear])
</div>
@vite(['resources/js/cus/heatmap-link-active.js'])
@endsection