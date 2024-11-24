<?php

namespace App\Livewire\TreasuryShifts;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\ShiftType;
use App\Models\TreasuryShift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\NewTreasuryShiftEvent;

class AddTreasuryShift extends Component
{
    public $treasury,$branch,$branch_id,$start_shift_cash_balance,$end_shift_cash_balance,$end_shift_bank_balance,$amount_delivered,$start_shift_date_time,$end_shift_date_time,
    $shifts,$amount_status,$amount_status_value,$delivered_shift_id,$delivered_to_shift_id,
    $user_id,$delivered_to_user_id,$shiftTypes,$bank_id,$current_shift,$next_shift,$last_shift,
    $currentTreasuryShift,$currentTime;


    public function mount()
    {
        $this->shiftTypes = ShiftType::all();

        // dd($this->shiftTypes);
        if($this->shiftTypes->isEmpty() ){
            $this->dispatch(
                'alert',
                text: trans('فضلا حدد انواع الورديات اولا من قائمة الموظفين - أنواع الورديات'),
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }
        else {

        
            $this->bank_id = Bank::where('name_ar','مصرف الراجحي')->first()->id;
            // dd($this->bank_id);
            $this->branch = Auth::user()->roles_name == 'سوبر-ادمن' ? null : Auth::user();
            $this->branch_id = $this->branch->id ?? null;       
            $this->user_id = Auth::user()->roles_name == 'سوبر-ادمن' ? null : Auth::user()->id;





            $this->currentTime = Carbon::now();
            $time  = $this->currentTime;
            

            $currentBranchShift = TreasuryShift::where('branch_id', $this->branch_id)
            ->where(function($query) use ($time) {
                $query->whereDate('start_shift_date_time', '<=', Carbon::today())
                    ->whereDate('end_shift_date_time', '>=', Carbon::today())
                    ->whereTime('start_shift_date_time', '<=', $this->currentTime)
                    ->whereTime('end_shift_date_time', '>=', $this->currentTime)
                    ->whereRaw('TIME(start_shift_date_time) < TIME(end_shift_date_time)');
            })
            ->orWhere(function($query) use ($time) {
                $query->whereDate('start_shift_date_time', '<=', Carbon::today())
                    ->whereTime('start_shift_date_time', '<=', $this->currentTime)
                    ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
            })
            ->orWhere(function($query) use ($time) {
                $query->whereDate('end_shift_date_time', '>=', Carbon::today())
                    ->whereTime('end_shift_date_time', '>=', $this->currentTime)
                    ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
            })
            ->whereDate('start_shift_date_time', '<=', $this->currentTime)
            ->whereDate('end_shift_date_time', '>=', $this->currentTime)
            ->latest()
            ->first();

                //dd($currentBranchShift);

            $this->current_shift= ShiftType::where(function($query) use ($time) {
                $query->whereTime('start', '<=', $this->currentTime)
                    ->whereTime('end', '>=', $this->currentTime)
                    ->whereRaw('start < end');
            })->orWhere(function($query) use ($time) {
                $query->whereTime('start', '<=', $this->currentTime)
                    ->whereRaw('start > end');
            })->orWhere(function($query) use ($time) {
                $query->whereTime('end', '>=', $this->currentTime)
                    ->whereRaw('start > end');
            })->first();

    
        // dd($this->currentTime );

            $shiftHours = $this->current_shift->total_hours;

            $lastShiftStartTime = Carbon::createFromTimeString($this->current_shift->start)->subHours($shiftHours);

            $this->last_shift = ShiftType::where('start', $lastShiftStartTime->toTimeString())->first();

            $this->next_shift = ShiftType::where('start', $this->current_shift->end)->first();

            //dd($this->last_shift );
        }    
    }

    public function branchChanged() {

        $this->treasury = Treasury::where('branch_id', $this->branch_id)->first();
        // dd($this->treasury);
        $this->start_shift_cash_balance = $this->treasury->current_balance;
    }
    public function rules() {
        $types = ShiftType::types();
        $states = TreasuryShift::states();

        return [
            'start_shift_cash_balance'=>'required|numeric',
            'end_shift_cash_balance'=>'required|numeric',
            'end_shift_bank_balance'=>'required|numeric',
            'start_shift_date_time'=>'required',
            'end_shift_date_time'=>'required',
            'delivered_to_shift_id' => 'required|exists:shift_types,id',
            'delivered_to_user_id'=>'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'start_shift_cash_balance.required' => trans('validation.start_shift_cash_balance_required'),
            'start_shift_cash_balance.numeric' => trans('validation.start_shift_cash_balance_numeric'),
            'end_shift_cash_balance.required' => trans('validation.end_shift_cash_balance_required'),
            'end_shift_cash_balance.numeric' => trans('validation.end_shift_cash_balance_numeric'),
            'end_shift_bank_balance.required' => trans('validation.end_shift_bank_balance_required'),
            'end_shift_bank_balance.numeric' => trans('validation.end_shift_cash_balance_numeric'),
            // 'amount_delivered.required' => trans('validation.amount_delivered_required'),
            // 'amount_delivered.numeric' => trans('validation.amount_delivered_numeric'),
            // 'amount_status_value.required' => trans('validation.amount_status_value_required'),
            // 'amount_status_value.numeric' => trans('validation.amount_status_value_numeric'),
            'start_shift_date_time.required'=> trans('validation.start_shift_date_time_required'),
            'end_shift_date_time.required'=> trans('validation.end_shift_date_time_required'),
            'delivered_shift_id.required'=> trans('validation.delivered_shift_id_required'),
            'delivered_shift_id.in'=> trans('validation.delivered_shift_id_in'),
            'delivered_to_shift_id.required'=> trans('validation.delivered_to_shift_id_required'),
            'delivered_to_user_id.required'=> trans('validation.delivered_to_required'),
            'delivered_to_shift_id.in'=> trans('validation.delivered_to_shift_id_in'),
            // 'amount_status.required'=> trans('validation.amount_status_required'),
        ];

    }


    public function create()
    {

        $time  = $this->currentTime;

        $this->currentTreasuryShift = TreasuryShift::where("delivered_to_user_id", $this->delivered_to_user_id)
            ->where('branch_id', $this->branch_id)
            ->where(function($query) use ($time) {
                $query->whereTime('start_shift_date_time', '<=', $this->currentTime)
                    ->whereTime('end_shift_date_time', '>=', $this->currentTime)
                    ->whereDate('start_shift_date_time',Carbon::now())
                    ->orWhereDate('end_shift_date_time',Carbon::now())
                    ->whereRaw('TIME(start_shift_date_time) < TIME(end_shift_date_time)');
            })->orWhere(function($query) use ($time) {
                $query->whereTime('start_shift_date_time', '<=', $this->currentTime)
                    ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
            })->orWhere(function($query) use ($time) {
                $query->whereTime('end_shift_date_time', '>=', $this->currentTime)
                    ->whereRaw('TIME(start_shift_date_time) > TIME(end_shift_date_time)');
            })
            ->whereDate('start_shift_date_time', '<=', $this->currentTime)
            ->whereDate('end_shift_date_time', '>=', $this->currentTime)
            ->latest()
            ->first();

            //dd($this->currentTreasuryShift);


            // Parse the next shift start and end times
            $nextShiftStart = Carbon::parse($this->next_shift->start);
            $nextShiftEnd = Carbon::parse($this->next_shift->end);
            //dd($nextShiftStart, $nextShiftEnd);

            // Adjust the start time if the current time is less than the end time and the shift spans midnight
            if ($this->currentTime->lessThan($nextShiftEnd) && $nextShiftEnd->lessThan($nextShiftStart)) {
                $nextShiftStart->subDay(); // Shift started yesterday
            }

            // Add a day to the end time if it spans midnight
            if ($nextShiftEnd->lessThan($nextShiftStart)) {
                $nextShiftEnd->addDay();
            }

            // Parse the last shift start and end times
            $lastShiftStart = Carbon::parse($this->last_shift->start);
            //dd($lastShiftStart);
            $lastShiftEnd = Carbon::parse($this->last_shift->end);

            // Adjust the start time if the current time is less than the end time and the shift spans midnight
            if ($this->currentTime->lessThan($lastShiftEnd) && $lastShiftEnd->lessThan($lastShiftStart)) {
                $lastShiftStart->subDay(); // Shift started yesterday
            }

            // Add a day to the end time if it spans midnight
            if ($lastShiftEnd->lessThan($lastShiftStart)) {
                $lastShiftEnd->addDay();
            }


                //dd($lastShiftStart,$lastShiftEnd);



        if (!$this->currentTreasuryShift) {

            if ($this->current_shift->start < Carbon::now()->toTimeString() && $this->current_shift->end > Carbon::now()->toTimeString()) {
                $this->delivered_shift_id = $this->last_shift->id;
                $this->delivered_to_shift_id = $this->current_shift->id;
                
                $this->start_shift_date_time = Carbon::parse($this->current_shift->start);
                $this->end_shift_date_time = Carbon::parse($this->current_shift->end);
            } else {
                $this->delivered_shift_id = $this->current_shift->id;
                $this->delivered_to_shift_id = $this->next_shift->id;

                
                $this->start_shift_date_time = $nextShiftStart;
                $this->end_shift_date_time = $nextShiftEnd;
            }
        } else {
            $this->dispatch(
                'alert',
                text: trans('الوردية الحالية بالفعل تم استلامها'),
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }
            //dd($this->delivered_shift_id);


        // try {


              
       $this->validate($this->rules() ,$this->messages());
 //dd($this->all());

            DB::beginTransaction();
            $treasuryShift = TreasuryShift::create([
                'user_id' => $this->user_id,
                'start_shift_cash_balance' => $this->start_shift_cash_balance,
                'end_shift_cash_balance' => $this->end_shift_cash_balance,
                'end_shift_bank_balance' => $this->end_shift_bank_balance,
                'amount_delivered' => 0,
                'start_shift_date_time' => $this->start_shift_date_time,
                'end_shift_date_time' => $this->end_shift_date_time,
                'is_approved' => 0,
                'is_delivered' => 1,
                'delivered_to_user_id' => $this->delivered_to_user_id,
                'delivered_shift_id' => $this->delivered_shift_id,
                'delivered_to_shift_id' => $this->delivered_to_shift_id,
                'branch_id' => $this->branch_id,
                'bank_id' => $this->bank_id == "" ? null : $this->bank_id ,
                'treasury_id' => Treasury::where('branch_id',$this->branch_id)->first()->id,
            ]);
            //dd($treasuryShift);

            //تحديث رصيد الخزينة  بجدول الخزن
            $this->treasury->update([
                'current_balance' =>  $this->end_shift_cash_balance,
            ]);

            //تحديث رصيد الخزينة  بالشجرة المحاسبية
            $treasuryAccount = Account::where('account_num',$this->treasury->account_num)->first();
            $treasuryAccount->update([
                'current_balance' => $this->end_shift_cash_balance,
            ]);





        $this->reset(['start_shift_cash_balance','end_shift_cash_balance','end_shift_bank_balance','start_shift_date_time','end_shift_date_time']);

            $this->dispatch('createModalToggle');

            if($this->bank_id) {
                event(new NewTreasuryShiftEvent($treasuryShift));
            }
            

            DB::commit();
            Alert::success(trans('admin.treasury_shift_created_successfully'));
            return redirect()->route('treasury_shifts');


    //     } catch (Exception $e) {
            DB::rollBack();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }

    }
    public function render()
    {
        return view('livewire.treasury-shifts.add-treasury-shift');
    }
}
