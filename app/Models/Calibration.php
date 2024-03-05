<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    use HasFactory;

    protected $fillable = ['shift', 'nik', 'measuring_device_id', 'expired_date','con_before_cal', 'con_after_cal', 'cal_date', 'cal_supplier', 'no_certificate', 'file1', 'file2', 'result', 'area_id', 'carname_id', 'service_place', 'start_ser_date' , 'finish_ser_date' , 'problem', 'life_time', 'next_action'] ;

    public function measuringDevice()
    {
        return $this->belongsTo(MeasuringDevice::class, 'measuring_device_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function carname()
    {
        return $this->belongsTo(Carname::class, 'carname_id');
    }
}
