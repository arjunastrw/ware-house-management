<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasuringDevice extends Model
{
    use HasFactory;

    protected $fillable = ['no_control','freq_cal_measuring_device_id', 'type_id', 'merk_id', 'no_seri', 'range_id', 'resolution_id', 'ata_sai', 'inv_no', 'no_doc_bc'];

    public function freq()
    {
        return $this->belongsTo(FreqCalMeasuringDevice::class, 'freq_cal_measuring_device_id');
    }


    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function merk()
    {
        return $this->belongsTo(Merk::class);
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }

    public function resolution()
    {
        return $this->belongsTo(Resolution::class);
    }

    public function calibration()
    {
        return $this->hasMany(Calibration::class);
    }
}
