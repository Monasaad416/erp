<?php

namespace App\Livewire\AdvancePayments;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\FinancialYear;
use App\Models\AdvancePayment;
use App\Models\FinancialMonth;

class DeleteAdvancePayment extends Component
{
    protected $listeners = ['deleteAdvancePayment'];
    public $advancePayment ,$financial_year_id,$advancePaymentName,$advancePaymentAmount,$advancePaymentMonth;

    public function deleteAdvancePayment($id)
    {
        $this->advancePayment = AdvancePayment::where('id',$id)->first();
        //dd($this->advancePayment);
        $this->advancePaymentName = User::where('id',$this->advancePayment->user_id)->first()->name;
        $this->advancePaymentAmount = $this->advancePayment->amount;

        $paymentYear= FinancialYear::where('id',$this->advancePayment->financial_year_id)->first()->year;
        $paymentMonth= FinancialMonth::where('id',$this->advancePayment->financial_month_id)->first()->month_id;
        $startMonth = Carbon::create($paymentYear, $paymentMonth)->addMonth()->format('F');
         
        $this->advancePaymentMonth = $startMonth;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
                $advancePayment = AdvancePayment::where('id',$this->advancePayment->id)->first();
                $monthNum = FinancialMonth::where('id',$advancePayment->financial_month_id)->first();
                if(  Carbon::now()->format('m') - $monthNum->month_id >= 2){
                    $this->dispatch('deleteModalToggle');
                    Alert::error('عفوا لا يمكن حذف سلفة تم تطبيقها علي راتب تم إستلامه');
                    return redirect()->route('users.advance_payments');
                } else {
                    $this->dispatch('deleteModalToggle');
                    $advancePayment->delete();
                    Alert::success('تم حذف الخصم بنجاح');
                    return redirect()->route('users.advance_payments');
                }

           
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.advance-payments.delete-advance-payment');
    }
}
