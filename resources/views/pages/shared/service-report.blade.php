<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <title>Service Report</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                padding: 0;
                border: none;
                box-shadow: none;
            }

            .line {
                margin: 5px 0;
            }
        }

        .line {
            border-bottom: 1px solid #dee2e6;
            margin: 5px 0;
        }

        .font-small {
            font-size: 0.9rem;
        }

        .font-tiny {
            font-size: 0.8rem;
        }

        .text-large {
            font-size: 1.2rem;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .signature-line {
            border-top: 1px solid #dee2e6;
            position: relative;
        }

        .sky-blue-text {
            color: #3783c9;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            height: 100%;
            max-height: 297mm;
            margin: 0 auto;
            overflow: hidden;
        }

        /* Responsive scrollable for smaller screens */
        @media (max-width: 768px) {
            .container {
                height: auto;
                overflow-y: auto;
            }
        }

        .w-full {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-padding {
            padding-left: 0;
            padding-right: 70px;
        }

        .signature-container {
            position: relative;
            display: inline-block;
        }

        .signature {
            position: absolute;
            top: 5px;
            left: 100px;
            height: 50px;
            z-index: 1;
            pointer-events: none;
        }

        .signature-container p {
            margin-top: 30px;
            position: relative;
            z-index: 0;
        }
    </style>
</head>

<body>
    <div class="container border bg-white">
        <table class="w-full">
            <tr>
                <td class="text-left">
                    <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" class="logo">
                </td>
                <td class="text-center">
                    <h4 style="margin: 5px;">CITY HEALTH OFFICE</h4>
                    <p style="margin: 5px;">Information & Communications Technology Section</p>
                    <h4 style="margin: 5px;">SERVICE REPORT</h4>
                </td>
                <td class="text-right">
                    <img src="data:image/jpg;base64,{{ $ictBase64 }}" alt="Logo" class="logo">
                </td>

            </tr>
        </table>
        <div class="line" style="margin-top: 25px;"></div>
        <table class="w-full">
            <tr>
                <td class="w-50">
                    <p class="font-small" style="margin-bottom: 0; margin-top: 0;"><strong>Date Received:</strong> {{
                        $ticket->created_at->format('F
                        j, Y g:i a') }}</p>
                </td>
                <td class="w-50 text-right">
                    <p class="font-small" style="margin-bottom: 0; margin-top: 0;"><strong>Claim Stub No.:</strong> {{
                        $ticket->id }}</p>
                </td>
            </tr>
        </table>
        <div class="line"></div>
        <div class="row mb-3">
            <div class="col-6">
                <p class="font-small" style="margin-bottom: 0px;"><strong>Facility:</strong> {{
                    $ticket->district->district_name }}</p>
                <div class="line"></div>
                <p class="font-small" style="margin-bottom: 0px;"><strong>Name:</strong> {{
                    $ticket->requestor->firstname . ' ' .
                    $ticket->requestor->lastname }}
                </p>
                <p class="font-small" style="margin-bottom: 0px;"><strong>Ticket Nature:</strong> {{
                    $ticket->ticketNature->ticket_nature_name }}
                </p>
            </div>
            <div class="line"></div>
        </div>

        <h5 class="font-small sky-blue-text" style="margin-top: 20px;">Equipment Details</h5>
        <div class="line"></div>
        <table class="w-full">
            <td class="w-100" style=" flex-direction: column;">
                <p class="font-small" style="margin: 0;"><strong>Equipment Type:</strong> {{
                    $ticket->device->device_name }}</p>
                <div class="line"></div>
                <p class="font-small" style="margin: 0;"><strong>Brand & Model:</strong>
                    @if($ticket->model == "N/A" || $ticket->brand == "N/A")
                    N/A
                    @else
                    {{ $ticket->brand . ' ' . $ticket->model }}
                    @endif
                </p>
            </td>
        </table>
        <div class="line"></div>
        <div class="line"></div>
        <table class="w-full">
            <tr>
                <td class="w-50" ">
                    <p class=" font-small" style="margin: 0;"><strong>Property No.:</strong> {{ $ticket->property_no }}
                    </p>
                </td>
                <td class="w-50 text-right">
                    <p class="font-small" style="margin: 0;"><strong>Serial No.:</strong> {{ $ticket->serial_no }}</p>
                </td>
            </tr>
        </table>
        <div class="line"></div>
        <h5 class="font-small sky-blue-text" style="margin-top: 20px;">Service Details</h5>
        <div class="line"></div>
        <table class="w-full">
            <td class="w-100 ">
                <p class="font-small" style="margin: 0;"><strong>Service Rendered:</strong> {{
                    $ticket->ticketAssign->service_rendered }}</p>
                <div class="line"></div>
                <p class="font-small" style="margin: 0;"><strong>Issue Found:</strong> {{
                    $ticket->ticketAssign->issue_found }}</p>
            </td>
        </table>
        <div class="line"></div>
        <h5 class="font-small sky-blue-text" style="margin-top: 20px;">Status after service</h5>
        <div class="line"></div>
        <table class="w-full">
            <tr>
                @foreach ($service_statuses as $status)
                <td>
                    <input class="form-check-input" type="radio" id="{{ $status }}" value="{{ $status }}" {{
                        $ticket->ticketAssign->service_status == $status ? 'checked' : '' }} style="pointer-events:
                    none; vertical-align: middle;">
                    <label class="form-check-label font-tiny" for="{{ $status }}">{{ $status }}</label>
                </td>
                @endforeach
            </tr>
        </table>

        <div class="line"></div>
        <div class="line" style="margin-bottom: 0; margin-top: 10px;"></div>
        <table class="w-full">
            <tr>
                <td class="text-left">
                    <p class="font-small" style="margin-bottom: 0; margin-top: 0;"><strong>Service Date:</strong> {{
                        \Carbon\Carbon::parse($ticket->ticketAssign->date_assigned)->format('n/j/y') }}</p>
                </td>
                <td class="text-center">
                    <p class="font-small" style="margin-bottom: 0; margin-top: 0;"><strong>Released Date:</strong> {{
                        \Carbon\Carbon::now()->format('n/j/y') }}
                    </p>
                </td>
                <td class="text-right">
                    <p class="font-small" style="margin-bottom: 0; margin-top: 0;"><strong>Released By:</strong> {{
                        $ticket->ticketAssign->technician->firstname
                        . ' ' .
                        $ticket->ticketAssign->technician->lastname }}</p>
                </td>
            </tr>
        </table>
        <div class="line"></div>
        <h5 class="font-small sky-blue-text" style="margin-top: 20px;">Report</h5>
        <table class="w-full">
            <tr>
                <div class="signature-line"></div>
                <div class="signature-container">
                    @if($technicianSignature != NULL)
                    <img src="data:image/png;base64,{{ $technicianSignature }}" class="signature">
                    @endif
                    <p class="font-small" style="margin-bottom: 0;"><strong>Serviced by:</strong>
                        {{ $ticket->ticketAssign->technician->firstname . ' ' .
                        $ticket->ticketAssign->technician->lastname }}
                    </p>
                </div>
            </tr>
            <tr>
                <td class="text-left">
                    <div class="signature-line"></div>
                    <div class="signature-container">
                        @if($assignedBySignature != NULL)
                        <img src="data:image/png;base64,{{ $assignedBySignature }}" class="signature">
                        @endif
                        <p class="font-small" style="margin-bottom: 0;"><strong>Approved by:</strong>
                            {{ $ticket->ticketAssign->assignedBy->firstname . ' ' .
                            $ticket->ticketAssign->assignedBy->lastname }}
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    <div class="signature-line"></div>
                    <div class="signature-container">
                        <p class="font-small" style="margin-bottom: 0;"><strong>Verified by:</strong>
                            @if($ifShowVerifyBy)
                            {{
                            $ticket->requestor->firstname . ' ' .
                            $ticket->requestor->lastname }}
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
        </table>
        <div class="line"></div>
    </div>
</body>

</html>