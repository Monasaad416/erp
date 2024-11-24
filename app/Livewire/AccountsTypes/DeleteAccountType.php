<?php

namespace App\Livewire\AccountsTypes;

use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\AccountType;

class DeleteAccountType extends Component
{

    protected $listeners = ['deleteAccountType'];
    public $accountType ,$accountTypeName;

    public function deleteAccountType($id)
    {
        $this->accountType = AccountType::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->accountType);
        $this->accountTypeName = $this->accountType->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $accountType = AccountType::where('id',$this->accountType->id)->first();

            // $products = Product::where('accountType_id',$this->accountType->id)->get();
            // if($products->count() > 0) {
            //     $this->dispatch('deleteModalToggle');
            //     $this->dispatch(
            //     'alert',
            //         text: trans('admin.cannot_delete_accountType'),
            //         icon: 'error',
            //         confirmButtonText: trans('admin.done'),

            //     );
            // } else {
                $accountType->delete();
                $this->reset('accountType');

                $this->dispatch('deleteModalToggle');

                $this->dispatch('refreshData')->to(DisplayAccountsTypes::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.account_type_deleted_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),

            );
            // }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.accounts-types.delete-account-type');
    }
}
