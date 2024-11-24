<?php

namespace App\Livewire\Commissions;

use Alert;
use Exception;
use Livewire\Component;
use App\Models\Commission;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteCommission extends Component
{
        protected $listeners = ['deleteProduct'];
    public $commission ,$productName;

    public function deleteProduct($id)
    {
        $this->commission = Commission::where('id',$id)->first();
        // dd($this->commission);
        $this->productName = $this->commission->product->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            Commission::where('id',$this->commission->id)->first()->delete();
            Alert::success('تم حذف المنتج من قائمة العمولات بنجاح');
            return redirect()->route('products.commissions');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }

    public function render()
    {
        return view('livewire.commissions.delete-commission');
    }
}
