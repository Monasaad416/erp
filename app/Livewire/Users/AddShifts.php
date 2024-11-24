<?php

namespace App\Livewire\Users;

use App\Models\Account;
use Livewire\Component;

class AddShifts extends Component
{
   protected $listeners = ['userAttendance'];

    public $name_ar,$name_en,$notes,$is_active,
    $account_num,$start_balance,$current_balance,
    $branch_id,$parent_id,$account_type_id,
    $created_by,$updated_by,$account,$is_parent = 0,$parent_account_num;



    public function userAttendance($id)
    {
        //return dd('dd');
        $this->account = Account::findOrFail($id);

        $this->name_en = $this->account->name_en;
        $this->name_ar = $this->account->name_ar;
        $this->notes = $this->account->notes;
        $this->account_num = $this->account->account_num;
        $this->start_balance = $this->account->start_balance;
        $this->current_balance = $this->account->current_balance;
        $this->branch_id = $this->account->branch_id;
        $this->parent_id = $this->account->parent_id;
        $this->account_type_id = $this->account->account_type_id;
        $this->name_en = $this->account->name_en;
        $this->name_ar = $this->account->name_ar;
        $this->is_active = $this->account->is_active;
        $this->is_parent = $this->account->is_parent;
        $this->parent_account_num = $this->account->parent_account_num;

        //  'parent_account_num' => $this->parent_id ? Account::where('id',$this->parent_id)->account_num : null,

        $this->resetValidation();

        $this->dispatch('createModalToggle');

    }

    public function render()
    {
        return view('livewire.users.add-shifts');
    }
}
