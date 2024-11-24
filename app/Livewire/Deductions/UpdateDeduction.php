<?php

namespace App\Livewire\Deductions;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Deduction;

class UpdateDeduction extends Component
{
    public $deduction,$branches=[],$users=[],$months=[],$branch_id,$financial_month_id,$user_id,$account_num ,$amount,$notes;
    protected $listeners = ['updateDeduction'];
 

    public function updateDeduction($id)
    {

        $this->deduction = Deduction::findOrFail($id);
    

        $this->user_id = $this->deduction->user_id;
       // dd($this->deduction->user_id);
        $this->branch_id = $this->deduction->branch_id;
        $this->financial_month_id = $this->deduction->financial_month_id;
        $this->amount = $this->deduction->amount;
        $this->account_num = $this->deduction->account_num;
        $this->notes = $this->deduction->notes;
        $this->users = User::where('branch_id', $this->deduction->branch_id)->get();
        
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

            'amount.nullable' => ' مبلغ الخصم مطلوب',
        ];

    }

  

    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

                if($this->deduction->financial_month_id < Carbon::now()->format('m')  || Carbon::parse($this->deduction->created_at)->format('Y') < Carbon::now()->format('Y')){
                    $this->dispatch('editModalToggle');
                    Alert::error('عفوا لا يمكن تعديل خصم تم تطبيقه علي راتب تم إستلامه');
                    return redirect()->route('users.deductions');
                } else {
                    $this->dispatch('editModalToggle');
                    $this->deduction->update($data);
                    $this->reset(['user_id','financial_month_id','branch_id','amount','notes']);
                    $this->dispatch('editModalToggle');
                    Alert::success('تم  تعديل الخصم بنجاح');
                    return redirect()->route('users.deductions');
                }

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.deductions.update-deduction');
    }
}
