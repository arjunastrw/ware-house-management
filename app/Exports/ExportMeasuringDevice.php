<?php

namespace App\Exports;

use App\Models\MeasuringDevice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportMeasuringDevice implements FromCollection, WithHeadings, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

//    public function collection()
//    {
//        return UploadMeasuringDevice::join('freq_cal_measuring_devices', 'measuring_devices.device_name', '=', 'freq_cal_measuring_devices.device_name')
//            ->join('types', 'measuring_devices.type_id', '=', 'types.id')
//            ->join('ranges', 'measuring_devices.range_id', '=', 'ranges.id')
//            ->join('resolutions', 'measuring_devices.resolution_id', '=', 'resolutions.id')
//            ->join('merks', 'measuring_devices.merk_id', '=', 'merks.id')
//            ->select('measuring_devices.no_control', 'freq_cal_measuring_devices.device_name', 'types.type', 'ranges.range', 'resolutions.resolution', 'merks.merk', 'measuring_devices.no_seri', 'freq_cal_measuring_devices.freq_cal_unit', 'freq_cal_measuring_devices.cal_status', 'calibrations.con_before_cal', 'calibrations.con_after_cal', 'calibrations.cal_date', 'calibrations.cal_supplier', 'calibrations.no_certificate', 'calibrations.result', 'areas.area', 'carnames.carname', 'calibrations.service_place', 'calibrations.start_ser_date', 'calibrations.finish_ser_date', 'calibrations.problem', 'calibrations.life_time', 'calibrations.next_action', 'calibrations.expired_date', 'calibrations.nik', 'calibrations.shift')
//            ->whereBetween('measuring_devices.created_at', [$this->startDate, $this->endDate])
//            ->get();
//    }

    public function collection()
    {
        return MeasuringDevice::leftJoin('freq_cal_measuring_devices', 'measuring_devices.freq_cal_measuring_device_id', '=', 'freq_cal_measuring_devices.id')
            ->leftJoin('types', 'measuring_devices.type_id', '=', 'types.id')
            ->leftJoin('ranges', 'measuring_devices.range_id', '=', 'ranges.id')
            ->leftJoin('resolutions', 'measuring_devices.resolution_id', '=', 'resolutions.id')
            ->leftJoin('merks', 'measuring_devices.merk_id', '=', 'merks.id')
            ->leftJoin('calibrations', 'measuring_devices.id', '=', 'calibrations.measuring_device_id')
            ->leftJoin('areas', 'calibrations.area_id', '=', 'areas.id')
            ->leftJoin('carnames', 'calibrations.carname_id', '=', 'carnames.id')
            ->select(
                'measuring_devices.no_control',
                'freq_cal_measuring_devices.device_name',
                'types.type',
                'ranges.range',
                'resolutions.resolution',
                'merks.merk',
                'measuring_devices.no_seri',
                'freq_cal_measuring_devices.freq_cal_num',
                'freq_cal_measuring_devices.cal_status',
                'calibrations.con_before_cal',
                'calibrations.con_after_cal',
                'calibrations.cal_date',
                'calibrations.cal_supplier',
                'calibrations.no_certificate',
                'calibrations.result',
                'areas.area',
                'carnames.carname',
                'calibrations.service_place',
                'calibrations.start_ser_date',
                'calibrations.finish_ser_date',
                'calibrations.problem',
                'calibrations.life_time',
                'calibrations.next_action',
                'calibrations.expired_date',
                'calibrations.nik',
                'calibrations.shift'
            )
            ->whereBetween('measuring_devices.created_at', [$this->startDate, $this->endDate])
            ->get();
    }
    public function headings(): array
    {
        return [
            'no',
            'no_control',
            'nama_device',
            'type',
            'range',
            'resolution',
            'merk',
            'no_seri',
            'freq_cal_num',
            'cal_status',
            'con_before_cal',
            'con_after_cal',
            'cal_date',
            'cal_supplier',
            'no_certificate',
            'result',
            'area',
            'carname',
            'service_place',
            'start_ser_date',
            'finish_ser_date',
            'problem',
            'life_time',
            'next_action',
            'expired_date',
            'nik',
            'shift',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:Z1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
