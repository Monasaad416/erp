<?php

namespace App\Livewire\Commissions;

use Exception;
use Livewire\Component;
use App\Models\Commission;
use Alert;

class UpdateCommission extends Component
{
    protected $listeners = ['updateProduct'];

    public $commission,$product_id,$commission_rate;

        public function updateProduct($product_id)
    {
        $this->commission = Commission::where('product_id',$product_id)->first();
        //dd($product_id);

        $this->product_id = $this->commission->product_id;
        $this->commission_rate = $this->commission->commission_rate;
        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');



    }



     public function mount()
    {
        $this->dispatch('newProducts');
    }
    public function rules() {
        return [
            'product_id' => 'required|exists:products,id',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [

            'product_id.required' => 'المنتج مطلوب',
            'product_id.exists' => 'المنتج الذي تم إدخالة غير موجود بقعدة البيانات',

            'commission_rate.numeric' => trans('validation.commission_rate_numeric'),
            'commission_rate.min' => trans('validation.commission_rate_min'),
            'commission_rate.max' => trans('validation.commission_rate_max'),


        ];

    }




    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

            $this->commission->update($data);

            $this->reset(['commission_rate','product_id']);

            $this->dispatch('editModalToggle');



            Alert::success('تم تعديل نسبة العمولة بنجاح');
            return redirect()->route('products.commissions');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }


    public function render()
    {
        return view('livewire.commissions.update-commission');
    }
}
