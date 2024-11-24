<?php

namespace App\Livewire\Commissions;

use Livewire\Component;
use Alert;
use App\Models\Commission;

class AddCommission extends Component
{
    public $product_id,$commission_rate;


    public function mount()
    {
        $this->dispatch('newProduct');
    }

    public function hydrate()
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

    public function create()
    {
        //dd($this->all());

        $this->validate($this->rules() ,$this->messages());
        //dd("kk");
        // try {

            $product  = new Commission();
            $product->product_id = $this->product_id;
            $product->commission_rate = $this->commission_rate;
            $product->save();

            Alert::success('تم إضافة منتج جديد لقائمة العمولة بنجاح');

            return redirect()->route('products.commissions');


        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }



    }
    public function render()
    {
        return view('livewire.commissions.add-commission');
    }
}
