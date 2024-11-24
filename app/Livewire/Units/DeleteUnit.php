<?php

namespace App\Livewire\Units;

use Exception;
use App\Models\Unit;
use App\Models\Product;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteUnit extends Component
{
    protected $listeners = ['deleteUnit'];
    public $unit ,$unitName;

    public function deleteUnit($id)
    {
        $this->unit = Unit::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->unit);
        $this->unitName = $this->unit->name;
        
        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try {
            $unit = Unit::where('id',$this->unit->id)->first();

            $products = Product::where('unit_id',$this->unit->id)->get();
            if($products->count() > 0) {
                $this->dispatch('deleteModalToggle');
                $this->dispatch(
                'alert',
                    text: trans('admin.cannot_delete_unit'),
                    icon: 'error',
                    confirmButtonText: trans('admin.done'),

                );
            } else {
                $unit->delete();
                $this->reset('unit');
                //dispatch browser events (js)
                //add event to toggle delete modal after remove row
                $this->dispatch('deleteModalToggle');

                //refrsh data after delete row
                $this->dispatch('refreshData')->to(DisplayUnits::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.unit_deleted_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),

            );
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        }


    }
    public function render()
    {
        return view('livewire.units.delete-unit');
    }
}
