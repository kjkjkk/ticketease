<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class CustomReport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    protected $columns;
    protected $ticketNatures;
    protected $districts;
    protected $dateFrom;
    protected $dateTo;
    protected $sheetPassword;

    public function __construct($columns, $ticketNatures, $districts, $dateFrom, $dateTo, $password)
    {
        $this->columns = $columns;
        $this->ticketNatures = $ticketNatures;
        $this->districts = $districts;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->sheetPassword = $password;
    }

    public function collection()
    {
        $query = DB::table('tickets')
            ->join('ticket_natures', 'tickets.ticket_nature_id', '=', 'ticket_natures.id')
            ->join('devices', 'tickets.device_id', '=', 'devices.id')
            ->join('districts', 'tickets.district_id', '=', 'districts.id')
            ->join('statuses', 'tickets.status_id', '=', 'statuses.id')
            ->join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
            ->join('ticket_completes', 'ticket_assigns.id', '=', 'ticket_completes.ticket_assign_id')
            ->join('users AS requestor', 'requestor.id', '=', 'tickets.requestor_id')
            ->join('users AS technician', 'technician.id', '=', 'ticket_assigns.technician_id')
            ->whereBetween('tickets.created_at', [$this->dateFrom, $this->dateTo])
            ->whereIn('tickets.ticket_nature_id', $this->ticketNatures)
            ->whereIn('tickets.district_id', $this->districts);

        $selectedColumns = [];

        foreach ($this->columns as $column) {
            $selectedColumns[] = DB::raw($column);
        }

        return $query->select($selectedColumns)->get();
    }

    public function mapHeadings()
    {
        return [
            'tickets.id' => 'TICKET ID',
            'CONCAT(requestor.firstname, " ", requestor.lastname)' => 'REQUESTOR NAME',
            'districts.district_name' => 'DISTRICT',
            'tickets.department' => 'DEPARTMENT',
            'ticket_natures.ticket_nature_name' => 'TICKET NATURE',
            'devices.device_name' => 'DEVICE',
            'tickets.brand' => 'BRAND',
            'tickets.model' => 'MODEL',
            'CONCAT(technician.firstname, " ", technician.lastname)' => 'SERVICE BY',
            'ticket_assigns.service_rendered' => 'SERVICE RENDERED',
            'ticket_assigns.issue_found' => 'ISSUE FOUND',
            'tickets.created_at as date_submitted' => 'DATE SUBMITTED',
            'ticket_completes.created_at as date_closed' => 'DATE CLOSED',
            'statuses.status_name' => 'STATUS',
        ];
    }

    public function headings(): array
    {
        $mappedHeadings = $this->mapHeadings();

        $headings = array_map(function ($column) use ($mappedHeadings) {
            return $mappedHeadings[$column] ?? $column;
        }, $this->columns);

        return $headings;
    }

    public function startCell(): string
    {
        return 'A3';
    }
    public function styles(Worksheet $sheet)
    {
        $lastColumn = $this->getNthLetter(count($this->columns));
        $sheet->mergeCells('A1:' . $lastColumn . "2");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '006769', // Yellow background for title
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $sheet->setCellValue('A1', 'From ' . Carbon::parse($this->dateFrom)->format('F j, Y') . " to " . Carbon::parse($this->dateTo)->format('F j, Y'));

        $sheet->getStyle('A3:' . $lastColumn . '3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getProtection()->setPassword($this->sheetPassword); // Set your password here
        $sheet->getProtection()->setSheet(true); // Enable protection for the sheet
        return [];
    }

    private function getNthLetter($n)
    {
        return chr(64 + $n);
    }
}
