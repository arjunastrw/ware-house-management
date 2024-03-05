<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carname extends Model
{
    use HasFactory;
    
    protected $fillable = ['carname'];

    public function calibration()
    {
        $this->hasMany(Calibration::class);
    }
}
