<?php

namespace App\Livewire\Customers;

use Exception;
use Livewire\Component;
use App\Models\Customer;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteCustomer extends Component
{
    
    protected $listeners = ['deleteCustomer'];
    public $customer ,$customerName;

    public function deleteCustomer($id)
    {
        $this->customer = Customer::where('id',$id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
    //dd($this->customer);
        $this->customerName = $this->customer->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            Customer::where('id',$this->customer->id)->delete();

            $this->reset('customer');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayCustomers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.customer_deleted_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.customers.delete-customer');
    }
}
