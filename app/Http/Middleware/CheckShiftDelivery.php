<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\ShiftType;
use Illuminate\Http\Request;
use App\Models\TreasuryShift;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckShiftDelivery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
      {
        $currentTime = Carbon::now();

        // $currentShift = TreasuryShift::where("delivered_to_user_id",Auth::user()->id)
        // ->where('branch_id',Auth::user()->branch_id)
        // ->where('start_shift_date_time', '<=', $currentTime)
        // ->where('end_shift_date_time', '>=', $currentTime)
        // ->latest()->first();
        // //dd($currentShift);

        $currentShift = TreasuryShift::where("delivered_to_user_id", Auth::user()->id)
                ->where('branch_id', Auth::user()->branch_id)
                ->where(function($query) use ($currentTime) {
                    $query->whereTime('start_shift_date_time', '<=', $currentTime)
                        ->whereTime('end_shift_date_time', '>=', $currentTime)
                        ->whereDate('start_shift_date_time',Carbon::now())
                        ->orWhereDate('end_shift_date_time',Carbon::now())
                        ->whereRaw('TIME(start_shift_date_time) < TIME(end_shift_date_time)');
                })->orWhere(function($query) use ($currentTime) {
                    $query->whereTime('start_shift_date_time', '<=', $currentTime)
                        ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
                })->orWhere(function($query) use ($currentTime) {
                    $query->whereTime('end_shift_date_time', '>=', $currentTime)
                        ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
                })
                ->whereDate('start_shift_date_time', '<=', $currentTime)
                ->whereDate('end_shift_date_time', '>=', $currentTime)
                ->latest()
                ->first();

                //dd($currentShift);

        if(Auth::user()->roles_name == 'سوبر-ادمن') {
             return $next($request);
        } else{
            if($currentShift){
                return $next($request);
            } else{
                return redirect()->route('confirm_shift_delivery_first');
            }
        }
    }
}
