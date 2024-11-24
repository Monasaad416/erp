<?php

namespace App\Livewire\Rewards;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Reward;

class UpdateReward extends Component
{
      public $reward,$branches=[],$users=[],$months=[],$branch_id,$financial_month_id,$user_id,$account_num ,$amount,$notes;
    protected $listeners = ['updateReward'];


    public function updateReward($id)
    {

        $this->reward = Reward::findOrFail($id);


        $this->user_id = $this->reward->user_id;
       // dd($this->reward->user_id);
        $this->branch_id = $this->reward->branch_id;
        $this->financial_month_id = $this->reward->financial_month_id;
        $this->amount = $this->reward->amount;
        $this->account_num = $this->reward->account_num;
        $this->notes = $this->reward->notes;
        $this->users = User::where('branch_id', $this->reward->branch_id)->get();

        //dd($this->users);



        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }
    // public function branchIdChanged()
    // {
    //     $this->selectedUsers = User::where('branch_id',$this->branch_id)->get();
    // }

    // public function getAccountNum()
    // {
    //     $this->account_num = User::where('id',$this->user_id)->first()->account_num;
    // }

    public function rules() {
        return [
            'user_id' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
            'financial_month_id' => 'nullable|exists:financial_months,id',
            'amount' => 'nullable|numeric',
            'notes' =>'nullable|string',
        ];
    }

    public function messages()
    {
        return [

            'user_id.exixtx' => 'إسم الموظف الذي تم إدخاله غير موجود بقاعدة البيانات',

            'branch_id.exixtx' => 'إسم الفرع الذي تم إدخاله غير موجود بقاعدة البيانات',

            'financial_month_id.exixtx' => 'إسم الشهر المالي الذي تم إدخاله غير موجود بقاعدة البيانات',

            'amount.nullable' => ' مبلغ المكافاءة مطلوب',
        ];

    }



    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {
                if($this->reward->financial_month_id < Carbon::now()->format('m')  || Carbon::parse($this->reward->created_at)->format('Y') < Carbon::now()->format('Y')){
                    $this->dispatch('editModalToggle');
                    Alert::error('عفوا لا يمكن تعديل مكافاءة تم اضافتها علي راتب تم إستلامه');
                    return redirect()->route('users.rewards');
                } else {
                    $this->dispatch('editModalToggle');
                    $this->reward->update($data);
                    $this->reset(['user_id','financial_month_id','branch_id','amount','notes']);
                    $this->dispatch('editModalToggle');
                    Alert::success('تم  تعديل المكافاءة بنجاح');
                    return redirect()->route('users.rewards');
                }

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.rewards.update-reward');
    }
}
