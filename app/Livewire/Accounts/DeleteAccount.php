<?php

namespace App\Livewire\Accounts;

use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Account;

class DeleteAccount extends Component
{

    protected $listeners = ['deleteAccount'];
    public $account ,$accountName;

    public function deleteAccount($id)
    {
        $this->account = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->account);
        $this->accountName = $this->account->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $account = Account::where('id',$this->account->id)->first();
            //dd($account);

            // $products = Product::where('account_id',$this->account->id)->get();
            // if($products->count() > 0) {
            //     $this->dispatch('deleteModalToggle');
            //     $this->dispatch(
            //     'alert',
            //         text: trans('admin.cannot_delete_account'),
            //         icon: 'error',
            //         confirmButtonText: trans('admin.done'),

            //     );
            // } else {
                $account->delete();
                $this->reset('account');

                $this->dispatch('deleteModalToggle');

                $this->dispatch('refreshData')->to(DisplayAccounts::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.account_deleted_successfully'),
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
        return view('livewire.accounts.delete-account');
    }
}
