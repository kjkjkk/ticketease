<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enum\ServiceStatus as EnumServiceStatus;
use App\Events\Logs\TicketActivityEvent;
use Exception;

class ServiceReportController extends Controller
{
    private function imageToBase64($imagePath)
    {
        $path = public_path($imagePath);
        try {
            $data = file_get_contents($path);
            return base64_encode($data);
        } catch (Exception $e) {
            return null;
        }
    }

    public function showpdf($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $service_statuses = EnumServiceStatus::values();
        $logoBase64 = $this->imageToBase64('img/cho.png');
        $ictBase64 = $this->imageToBase64('img/ict.jpg');
        $assignedBySignature = $this->imageToBase64('/' . $ticket->ticketAssign->assignedBy->signature);
        $technicianSignature = $this->imageToBase64('/' . $ticket->ticketAssign->technician->signature);
        return view('pages.shared.service-report', compact('ticket', 'service_statuses', 'logoBase64',  'ictBase64', 'assignedBySignature', 'technicianSignature'));
    }

    public function pdfinbrowser(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ifShowVerifyBy = $request->showVerifyBy;
        $service_statuses = EnumServiceStatus::values();
        $logoBase64 = $this->imageToBase64('img/cho.png');
        $ictBase64 = $this->imageToBase64('img/ict.jpg');
        $assignedBySignature = $this->imageToBase64('/storage/' . $ticket->ticketAssign->assignedBy->signature);
        $technicianSignature = $this->imageToBase64('/storage/' . $ticket->ticketAssign->technician->signature);
        $pdf = Pdf::loadView('pages.shared.service-report', compact('ticket', 'service_statuses', 'logoBase64',  'ictBase64', 'assignedBySignature', 'technicianSignature', 'ifShowVerifyBy'));
        $pdf->setPaper('a4', 'portrait'); // Set paper size and orientation
        $pdf->setOptions([
            'margin_right' => 0,
            'margin_left' => 0,
        ]);
        event(new TicketActivityEvent($ticket, "Generated a service report."));
        return $pdf->stream('service-report.pdf');
    }

    public function downloadpdf(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ifShowVerifyBy = $request->showVerifyBy;
        $service_statuses = EnumServiceStatus::values();
        $logoBase64 = $this->imageToBase64('img/cho.png');
        $ictBase64 = $this->imageToBase64('img/ict.jpg');
        $assignedBySignature = $this->imageToBase64('/storage/' . $ticket->ticketAssign->assignedBy->signature);
        $technicianSignature = $this->imageToBase64('/storage/' . $ticket->ticketAssign->technician->signature);
        $pdf = Pdf::loadView('pages.shared.service-report', compact('ticket', 'service_statuses', 'logoBase64',  'ictBase64', 'assignedBySignature', 'technicianSignature', 'ifShowVerifyBy'));
        $pdf->setPaper('a4', 'portrait'); // Set paper size and orientation
        $pdf->setOptions([
            'margin_right' => 0,
            'margin_left' => 0,
        ]);
        event(new TicketActivityEvent($ticket, "Downloaded a service report."));
        return $pdf->download('service-report.pdf');
    }
}
