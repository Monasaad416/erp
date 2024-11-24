<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    const MORNINIG8 = 1;
    const EVINING8 = 2;
    const NIGHTT8 = 3;
    const MORNINIG12 = 4;
    const NIGHT12 = 5;



    public function label()
    {
        return match($this->type)
        {
            self::MORNINIG8 => trans('admin.morning_shift_8'),
            self::EVINING8 => trans('admin.evening_shift_8'),
            self::NIGHTT8 => trans('admin.night_shift_8'),
            self::MORNINIG12 => trans('admin.morning_shift_12'),
            self::NIGHT12 => trans('admin.night_shift_12'),
            default => 'unknown',
        };
    }

    public static function types() {
        return [self::MORNINIG8,self::EVINING8,self::NIGHTT8,self::MORNINIG12,self::NIGHT12];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
