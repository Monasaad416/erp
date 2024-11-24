<?php

namespace App\Livewire\Suppliers;

use Exception;
use Livewire\Component;
use App\Models\Supplier;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteSupplier extends Component
{
    
    protected $listeners = ['deleteSupplier'];
    public $supplier ,$supplierName;

    public function deleteSupplier($id)
    {
        $this->supplier = Supplier::where('id',$id)->first();
    //dd($this->supplier);
        $this->supplierName = $this->supplier->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            Supplier::where('id',$this->supplier->id)->delete();

            $this->reset('supplier');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplaySuppliers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.supplier_deleted_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.suppliers.delete-supplier');
    }
}
