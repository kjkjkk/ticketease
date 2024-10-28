<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyReport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell
{
    public $year;
    public $month;
    public $sheetPassword;

    public function __construct($year, $month, $password)
    {
        $this->year = $year;
        $this->month = $month;
        $this->sheetPassword = $password;
    }

    public function collection()
    {
        return DB::table('tickets')
            ->select(
                'tickets.id AS TICKET_ID',
                'districts.district_name AS DISTRICT',
                'ticket_natures.ticket_nature_name AS TICKET_NATURE',
                'devices.device_name AS DEVICE',
                'tickets.brand AS BRAND',
                'tickets.model AS MODEL',
                DB::raw("CONCAT(technician.lastname, ', ', technician.firstname) AS SERVICE_BY"),
                'ticket_assigns.issue_found',
                'tickets.created_at AS DATE_SUBMITTED',
                'ticket_completes.created_at AS DATE_CLOSED',
            )
            ->join('ticket_natures', 'tickets.ticket_nature_id', '=', 'ticket_natures.id')
            ->join('districts', 'tickets.district_id', '=', 'districts.id')
            ->join('devices', 'tickets.device_id', '=', 'devices.id')
            ->join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->join('users AS technician', 'ticket_assigns.technician_id', '=', 'technician.id')
            ->join('ticket_completes', 'ticket_assigns.id', '=', 'ticket_completes.ticket_assign_id')
            ->whereYear('tickets.created_at', $this->year)
            ->whereMonth('tickets.created_at', $this->month)
            ->where('tickets.status_id', 10)
            ->get();
    }

    public function headings(): array
    {
        return [
            'TICKET ID',
            'DISTRICT',
            'TICKET NATURE',
            'DEVICE',
            'BRAND',
            'MODEL',
            'SERVICE BY',
            'ISSUE FOUND',
            'DATE SUBMITTED',
            'DATE CLOSED',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J2');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'EEEE00',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $sheet->setCellValue('A1', 'Ticket Monthly Summary, ' . date('F Y', mktime(0, 0, 0, $this->month, 10, $this->year)));

        $sheet->getStyle('A3:J3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getProtection()->setPassword($this->sheetPassword); // Set your password here
        $sheet->getProtection()->setSheet(true); // Enable protection for the sheet
        return [];
    }
}
