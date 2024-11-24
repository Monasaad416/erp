<?php

namespace App\Livewire\Accounts;

use Exception;
use App\Models\Account;
use Livewire\Component;
use App\Livewire\Accounts\DisplayAccounts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestoreAccount extends Component
{
    
    protected $listeners = ['restoreAccount'];
    public $account ,$accountName;

    public function restoreAccount($id)
    {
        dd(";;");
        $this->account = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->account);
        $this->accountName = $this->account->name;

        $this->dispatch('restoreModalToggle');

    }


    public function restore()
    {
        try{
            $account = Account::where('id',$this->account->id)->first();

                $account->restore();
                $this->reset('account');

                $this->dispatch('restoreModalToggle');

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
        return view('livewire.accounts.restore-account');
    }
}
