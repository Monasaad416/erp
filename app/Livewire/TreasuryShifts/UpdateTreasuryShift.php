<?php

namespace App\Livewire\TreasuryShifts;

use Exception;
use Livewire\Component;
use App\Models\Category;
use App\Models\ShiftType;
use App\Models\TreasuryShift;
use Illuminate\Validation\Rule;
use App\Events\NewTreasuryShiftEvent;
use App\Livewire\ShiftsType\DisplayShifts;
use App\Livewire\TreasuryShifts\DisplayTreasuryShifts;

class UpdateTreasuryShift extends Component
{
    protected $listeners = ['updateTreasuryShift'];
    public $shiftTypes,$shiftType,$treasuryShift,$start_shift_cash_balance,$end_shift_cash_balance,$end_shift_bank_balance,$amount_delivered,$start_shift_date_time,$end_shift_date_time,
    $shifts,$amount_status,$amount_status_value,$delivered_shift_id,$delivered_to_shift_id,
    $delivered_to,$bank_id;

    public function updateTreasuryShift($id)
    {

        $this->treasuryShift = TreasuryShift::findOrFail($id);

        $this->start_shift_cash_balance = $this->treasuryShift->start_shift_cash_balance;
        $this->end_shift_cash_balance = $this->treasuryShift->end_shift_cash_balance;
        $this->end_shift_bank_balance = $this->treasuryShift->end_shift_bank_balance;
        $this->delivered_shift_id = $this->treasuryShift->delivered_shift_id;
        $this->delivered_to_shift_id = $this->treasuryShift->delivered_to_shift_id;
        $this->start_shift_date_time = $this->treasuryShift->start_shift_date_time;
        $this->end_shift_date_time = $this->treasuryShift->end_shift_date_time;
        $this->amount_delivered = $this->treasuryShift->amount_delivered;
        $this->amount_status = $this->treasuryShift->amount_status;
        $this->amount_status_value = $this->treasuryShift->amount_status_value;
        $this->delivered_to = $this->treasuryShift->delivered_to;
        $this->bank_id = $this->treasuryShift->bank_id;


        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function mount()
    {
        $this->shiftTypes = ShiftType::all();
    }
    public function rules() {
        $types = ShiftType::types();
        $states = TreasuryShift::states();

        return [
            'start_shift_cash_balance'=>'nullable|numeric',
            'end_shift_cash_balance'=>'nullable|numeric',
            'end_shift_bank_balance'=>'nullable|numeric',
            // 'amount_delivered'=>'nullable|numeric',
            'start_shift_date_time'=>'nullable',
            'end_shift_date_time'=>'nullable',
            'delivered_shift_id' => 'nullable|exists:shift_types,id',
            'delivered_to_shift_id' => 'nullable|exists:shift_types,id',
            'delivered_to'=>'nullable|exists:users,id',
            // 'amount_status'=>'nullable|numeric|in:'.implode(',',$states),
            // 'amount_status_value'=>'nullable|numeric',
            // 'financial_movement_id'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'start_shift_cash_balance.nullable' => trans('validation.start_shift_cash_balance_nullable'),
            'start_shift_cash_balance.numeric' => trans('validation.start_shift_cash_balance_numeric'),
            'end_shift_cash_balance.nullable' => trans('validation.end_shift_cash_balance_nullable'),
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
            'delivered_to.required'=> trans('validation.delivered_to_required'),
            'delivered_to_shift_id.in'=> trans('validation.delivered_to_shift_id_in'),
            // 'amount_status.required'=> trans('validation.amount_status_required'),
        ];

    }

    // public function updated()
    // {
    //     $diff = $this->amount_status_value =  $this->amount_delivered - $this->end_shift_balance;
    //     if($diff == 0 ){
    //         $this->amount_status = 1;
    //     }
    //     elseif($diff < 0 ){
    //         $this->amount_status = 2;
    //     }elseif($diff > 0 ) {
    //          $this->amount_status = 3;
    //     }
    // }


   public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->treasuryShift->update($data);
            event(new NewTreasuryShiftEvent($this->treasuryShift));

        $this->reset(['start_shift_cash_balance','end_shift_cash_balance','end_shift_bank_balance','start_shift_date_time','end_shift_date_time',
        'delivered_shift_id','delivered_to_shift_id']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayTreasuryShifts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.user_shift_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.treasury-shifts.update-treasury-shift');
    }
}
