<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Livewire\Component;
use App\Livewire\Accounts\DisplayAccounts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DestroyAccount extends Component
{
    protected $listeners = ['destroyAccount'];
    public $account ,$accountName;

    public function destroyAccount($id)
    {
        $this->account = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->account);
        $this->accountName = $this->account->name;

        $this->dispatch('destroyModalToggle');

    }


    public function destroy()
    {
        try{
            $account = Account::where('id',$this->account->id)->first();

                $account->destroy();
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
        return view('livewire.accounts.destroy-account');
    }
}
