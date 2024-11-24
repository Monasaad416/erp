<?php

namespace App\Livewire\Deductions;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Deduction;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;

class DeleteDeduction extends Component
{
    protected $listeners = ['deleteDeduction'];
    public $deduction ,$deductionName,$deductionAmount,$deductionMonth;

    public function deleteDeduction($id)
    {
        $this->deduction = Deduction::where('id',$id)->first();
        //dd($this->deduction);
        $this->deductionName = User::where('id',$this->deduction->user_id)->first()->name;
        $this->deductionAmount = $this->deduction->amount;
        $this->deductionMonth = $this->deduction->financialMonth->month_name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
                $deduction = Deduction::where('id',$this->deduction->id)->first();
                if($deduction->financial_month_id < Carbon::now()->format('m')  || Carbon::parse($deduction->created_at)->format('Y') < Carbon::now()->format('Y')){
                    $this->dispatch('deleteModalToggle');
                    Alert::error('عفوا لا يمكن حذف خصم تم تطبيقه علي راتب تم إستلامه');
                    return redirect()->route('users.deductions');
                } else {
                    $this->dispatch('deleteModalToggle');

                    $deduction->delete();
                    Alert::success('تم حذف الخصم بنجاح');
                    return redirect()->route('users.deductions');
                }

           
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.deductions.delete-deduction');
    }
}
