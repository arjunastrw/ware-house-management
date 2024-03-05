<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreqCalMeasuringDevice extends Model
{
    use HasFactory;

    protected $fillable =
    ['device_name', 'cal_status', 'freq_cal_num', 'life_time_num'];

    public function measuringDevices()
    {
        return $this->hasMany(MeasuringDevice::class);
    }
}
