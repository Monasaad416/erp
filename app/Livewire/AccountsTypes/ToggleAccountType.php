<?php

namespace App\Livewire\AccountsTypes;

use Exception;
use Livewire\Component;
use App\Models\AccountType;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleAccountType extends Component
{
    public $id,$accountType ,$is_active,$accountTypeName;
    protected $listeners = ['toggleAccountType'];
    public function toggleAccountType($id)
    {
        $this->id = $id;
        $this->accountType = AccountType::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->accountTypeName = $this->accountType->name;
       // return dd($this->accountType->is_active);
        $this->is_active = $this->accountType->is_active;
        $this->dispatch('changeStateModalToggle');
    }

    public function toggle()
    {
        try{
            if( $this->accountType->is_active == 1 ) {
                $this->accountType->is_active = 0;
                $this->accountType->save();
            }else {
                $this->accountType->is_active = 1;
                $this->accountType->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayAccountsTypes::class);

            $this->dispatch(
            'alert',
                text: trans('admin.accountType_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {

        return view('livewire.accounts-types.toggle-account-type',['accountType' => $this->accountType]);
    }
}
