<?php

namespace App\Exports;

use App\Models\MeasuringDevice;
use App\Models\Calibration;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class HistoryCalExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, ShouldAutoSize, WithEvents
{
    protected $measuringDevices;
    protected $calibration;

    public function __construct($measuringDevices, $calibration)
    {
        $this->measuringDevices = $measuringDevices instanceof Collection ? $measuringDevices : collect([$measuringDevices]);
        $this->calibration = $calibration;
    }

    public function collection()
    {
        $measuringDevices = MeasuringDevice::findOrFail($this->measuringDevices->pluck('id'));

        // Collect calibration data for each measuring device
        $calibrations = collect([]);

        foreach ($measuringDevices as $device) {
            $calibration = Calibration::where('measuring_device_id', $device->id)->get();
            $calibrations->push($calibration);
        }

        // Combine measuring devices with their corresponding calibration data
        return $measuringDevices->zip($calibrations)->map(function ($item, $index) {
            [$device, $calibration] = $item;
            $device->calibration = $calibration;
            $device->no_control_styled = "CN-" . str_pad($index + 1, 5, '0', STR_PAD_LEFT); // Format the control number
            return $device;
        });
    }

    public function map($device): array
{
    $mappedData = [];

    // Initialize the loop index
    $calibrationIndex = 1;

    foreach ($device->calibration as $calibration) {
        $resultOk = $calibration->result === 'OK' ? 'OK' : '-';
        $resultNok = $calibration->result === 'N-OK' ? 'N-OK' : '-';
        $mappedData[] = [
            $calibrationIndex, // No (sequential number)
            $calibration->con_after_cal,
            $calibration->con_before_cal, // Result
            date('d-M-Y', strtotime($calibration->cal_date)), // Calibration Date formatted as dd-MMM-yyyy
            $calibration->no_certificate, // No. Certificate
            $resultOk, // Result OK sub-column
            $resultNok, // Result N-OK sub-column
            $calibration->area->area, // Area
            $calibration->carname->carname, // Carname
            $calibration->service_place, // Service Place
            $calibration->start_ser_date, // Start
            $calibration->end_ser_date, // End
            $calibration->problem, // Problem
            $calibration->next_action, // Next Action
            $calibration->expired_date, // Next Calibration
            $calibration->nik, // NIK
        ];
        
        // Increment the loop index for the next calibration
        $calibrationIndex++;
    }

    return $mappedData;
}

    public function headings(): array
    {
        return [
            'No',
            'Before Calibration',
            'After Calibration',
            'Date',
            'Calibration Place',
            'No Certificate',
            'OK',
            'N-OK',
            'Area',
            'Carname',
            'Service Place',
            'Service Date',
            'Service Done',
            'Problem',
            'Status',
            'Next Calibration',
            'NIK',
        ];
    }

    public function startCell(): string
    {
        return 'A9';
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class    => function(AfterSheet $event) {
            // Set additional headers from the view
            $event->sheet->setCellValue('A1', 'Control Measuring Device');
            $event->sheet->mergeCells('A1:P1'); // Merge cells for the header
            $event->sheet->getStyle('B6:C6')->getAlignment()->setWrapText(true);

            // Set wrap text for merged cells C7:C9
            $event->sheet->getStyle('C7:C9')->getAlignment()->setWrapText(true);            $event->sheet->getStyle('A6:P9')->applyFromArray([
                'font' => ['bold' => true], // Make header bold
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ADD8E6']] // Set cell color to light blue
            ]);

            $event->sheet->setCellValue('A2', 'Device Name');
            $event->sheet->mergeCells('A2:B2'); // Merge cells for the device name
            $event->sheet->setCellValue('C2', ': ' . $this->measuringDevices->first()->no_control);
            $event->sheet->mergeCells('C2:D2'); // Merge cells for the device name

            $event->sheet->setCellValue('E2', 'Range: ' . $this->measuringDevices->first()->range->range);
            $event->sheet->mergeCells('E2:G2'); // Merge cells for the range
            $event->sheet->setCellValue('H2', 'Merk: ' . $this->measuringDevices->first()->merk->merk);
            $event->sheet->mergeCells('H2:K2'); // Merge cells for the merk

            $event->sheet->setCellValue('A3', 'No Control');
            $event->sheet->mergeCells('A3:B3'); // Merge cells for the no control
            $event->sheet->setCellValue('C3', ': ' . $this->measuringDevices->first()->freq->device_name);
            $event->sheet->mergeCells('C3:D3'); // Merge cells for the no control

            $event->sheet->setCellValue('E3', 'Resolution: ' . $this->measuringDevices->first()->resolution->resolution);
            $event->sheet->mergeCells('E3:G3'); // Merge cells for the resolution
            $event->sheet->setCellValue('H3', 'No Seri: ' . $this->measuringDevices->first()->no_seri);
            $event->sheet->mergeCells('H3:K3'); // Merge cells for the no seri

            $event->sheet->setCellValue('A4', 'Type: ' . $this->measuringDevices->first()->type->type);
            $event->sheet->mergeCells('A4:D4'); // Merge cells for the type
            $event->sheet->setCellValue('E4', 'ATA SAI: ' . $this->measuringDevices->first()->ata_sai);
            $event->sheet->mergeCells('E4:G4'); // Merge cells for the ata sai
            $event->sheet->setCellValue('H4', 'Invoice No: ' . $this->measuringDevices->first()->inv_no);
            $event->sheet->mergeCells('H4:K4'); // Merge cells for the invoice no

            //Header
            $event->sheet->setCellValue('A6', 'NO');
            $event->sheet->mergeCells('A6:A9');

            $event->sheet->setCellValue('B6', 'DEVICE CONDITION');
            $event->sheet->mergeCells('B6:C6');
                $event->sheet->setCellValue('B7', 'Before Calibration');
                $event->sheet->mergeCells('B7:B9');
                $event->sheet->setCellValue('C7', 'After Cal');
                $event->sheet->mergeCells('C7:C9');

            $event->sheet->setCellValue('D6', 'CALIBRATION');
                $event->sheet->mergeCells('D6:O6');
                    $event->sheet->setCellValue('D7', 'Date');
                        $event->sheet->mergeCells('D7:D9');
                    $event->sheet->setCellValue('E7', 'No Certificate');
                        $event->sheet->mergeCells('E7:E9');
                    $event->sheet->setCellValue('F7', 'Result');
                        $event->sheet->mergeCells('F7:G7');
                            $event->sheet->setCellValue('F8', 'OK');
                                $event->sheet->mergeCells('F8:F9');
                            $event->sheet->setCellValue('G8', 'N-OK');
                                $event->sheet->mergeCells('G8:G9');
                    $event->sheet->setCellValue('H7', 'Actual Location');
                        $event->sheet->mergeCells('H7:I7');
                            $event->sheet->setCellValue('H8', 'Area');
                                $event->sheet->mergeCells('H8:H9');
                            $event->sheet->setCellValue('I8', 'Carname');
                                $event->sheet->mergeCells('I8:I9');
                    $event->sheet->setCellValue('J7', 'Action / Information');
                        $event->sheet->mergeCells('J7:N7');
                            $event->sheet->setCellValue('J8', 'Service Place');
                                $event->sheet->mergeCells('J8:J9');
                            $event->sheet->setCellValue('K8', 'Service Date');
                                $event->sheet->mergeCells('K8:K9');
                                $event->sheet->setCellValue('L8', 'Service Done');
                                $event->sheet->mergeCells('L8:L9');
                            $event->sheet->setCellValue('M8', 'Problem');
                                $event->sheet->mergeCells('M8:M9');
                            $event->sheet->setCellValue('N8', 'Status');
                                $event->sheet->mergeCells('N8:N9');
                    $event->sheet->setCellValue('O7', 'Expired Date');
                        $event->sheet->mergeCells('O7:O9');
                    $event->sheet->setCellValue('P6', 'NIK');
                        $event->sheet->mergeCells('P6:P9');


            $event->sheet->getStyle('A6:P9')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true, // Enable text wrapping
                ],
            ]);

            $event->sheet->getStyle('A1:P1')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);
            
            // Adjust column widths
            $event->sheet->getColumnDimension('A')->setAutoSize(true); // No Control
            $event->sheet->getColumnDimension('B')->setAutoSize(true); // Calibration Date
            $event->sheet->getColumnDimension('C')->setAutoSize(true); // No. Certificate
            $event->sheet->getColumnDimension('D')->setAutoSize(true); // Result
            $event->sheet->getColumnDimension('E')->setAutoSize(true); // Area
            $event->sheet->getColumnDimension('F')->setAutoSize(true); // Carname
            $event->sheet->getColumnDimension('G')->setAutoSize(true); // Next Calibration
            $event->sheet->getColumnDimension('H')->setAutoSize(true); // NIK

            // Apply borders
            $event->sheet->getStyle('A6:P' . ($this->collection()->count() + 5))->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]); // Apply border to data rows
            $alphabet       = $event->sheet->getHighestDataColumn();
            $totalRow       = $event->sheet->getHighestDataRow();
            $cellRange      = 'A7:'.$alphabet.$totalRow;

            $event->sheet->getStyle($cellRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true, // Enable text wrapping
                ],
            ])->getAlignment()->setWrapText(true);
            
            
            
            
        },
    ];
}

}
