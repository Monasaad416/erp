<?php

namespace App\Livewire\Accounts;

use Exception;
use Livewire\Component;
use App\Models\Account;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleAccount extends Component
{
    public $id,$account ,$is_active,$accountName;
    protected $listeners = ['toggleAccount'];
    public function toggleAccount($id)
    {
        $this->id = $id;
        $this->account = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->accountName = $this->account->name;
       // return dd($this->account->is_active);
        $this->is_active = $this->account->is_active;
        $this->dispatch('changeStateModalToggle');
    }

    public function toggle()
    {
        try{
            if( $this->account->is_active == 1 ) {
                $this->account->is_active = 0;
                $this->account->save();
            }else {
                $this->account->is_active = 1;
                $this->account->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayAccounts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.account_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {

        return view('livewire.accounts.toggle-account',['account' => $this->account]);
    }
}
