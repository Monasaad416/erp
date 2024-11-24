<?php

namespace App\Livewire\Taxes;

use Alert;
use Mockery\Exception;
use Livewire\Component;
use App\Models\AdjustedTaxes;
use Illuminate\Support\Facades\DB;
use App\Events\TaxesAdjustmentEvent;

class ApproveTaxAdjustment extends Component
{
    public $id,$tax,$start_date,$end_date,$adjust_date,$is_adjusted=false,$payment_method,$bank_id;
    protected $listeners = ['approveTaxAdjustmentWithZatca'];

        public function rules() {
        return [
            'payment_method' => 'required|in:treasury,bank',
            'bank_id' =>  'required_if:payment_method,bank',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => 'اختر طريقة سداد الضرائب ',
            'bank_id.required_if' => 'اختر البنك الذي تم السداد عن طريقة',
        ];
    }


    public function approveTaxAdjustmentWithZatca($id)
    {
        $this->id = $id;
        $this->tax = AdjustedTaxes::where('id',$id)->first();
        $this->start_date = $this->tax->start_date;
        $this->end_date = $this->tax->end_date;

        //dd($this->tax);

        $this->dispatch('adjustTaxesModalToggle');
    }


    public function approve()
    {
        $this->validate($this->rules() ,$this->messages());
        try{
            DB::beginTransaction();
            if( $this->tax->is_adjusted == 0 ){
                //dd($this->bank_id,$this->payment_method);
                $this->tax->is_adjusted = 1;
                $this->tax->payment_method = $this->payment_method;
                $this->tax->bank_id = $this->bank_id ?? null;
                $this->tax->save();


                event(new TaxesAdjustmentEvent($this->tax,$this->adjust_date));
                DB::commit();
            }
            $this->dispatch('adjustTaxesModalToggle');

            $this->dispatch('refreshData')->to(DisplayTaxes::class);

            // $this->dispatch(
            // 'alert',
            //     text: 'تم حفظ تسوية الضرائب مع هيأة الضريبة والدخل و الجمارك بنجاح',
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')

            // );

            Alert::success('تم حفظ تسوية الضرائب مع هيأة الضريبة والدخل و الجمارك بنجاح');
            return redirect()->route('adjust_taxes');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.taxes.approve-tax-adjustment',['tax' => $this->tax]);
    }
}
