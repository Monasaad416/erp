<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TreasuryShift extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    const BALANCED = 1;
    const SHORTAGE = 2;
    const SURPLUS = 3;


    public function status_label()
    {
        return match($this->amount_status)
        {
            self::BALANCED => trans('admin.balanced'),
            self::SHORTAGE => trans('admin.shortage'),
            self::SURPLUS => trans('admin.surplus'),
            default => 'unknown',
        };
    }

        public static function states() {
        return [self::BALANCED,self::SHORTAGE,self::SURPLUS];
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

     public function deliveredShiftType()
    {
       return $this->belongsTo(ShiftType::class,'delivered_shift_id');
    }


    public function deliveredToShiftType()
    {
       return $this->belongsTo(ShiftType::class,'delivered_to_shift_id');
    }

    public function deliveredTo()
    {
       return $this->belongsTo(User::class,'delivered_to_user_id');
    }

    public function delivered()
    {
       return $this->belongsTo(User::class,'user_id');
    }
}
