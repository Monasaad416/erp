<?php

namespace App\Livewire\Capitals;

use Alert;
use Exception;
use App\Models\Account;
use App\Models\Capital;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Events\NewCapitAlAddedEvent;
use App\Livewire\Capitals\DisplayCapitals;

class UpdateCapital extends Component
{
        protected $listeners = ['updateCapital'];
        public $capital,$amount,$start_date,$partner_id,$type,$bank_id,$treasury_id,$check_num;


    public function updateCapital($id)
    {
        $this->capital = Capital::findOrFail($id);

        $this->amount = $this->capital->amount;
        $this->start_date = $this->capital->start_date;
        $this->partner_id = $this->capital->partner_id;
        $this->type = $this->capital->capitalizable_type = "App\Models\Bank" ? 'bank':'treasury';
        $this->bank_id = $this->capital->capitalizable_id;
         $this->check_num = $this->capital->check_num;
        $this->treasury_id = $this->capital->capitalizable_id;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }


    public function rules() {
        return [

            'amount' =>'nullable|numeric|min:0',
            'start_date' =>'nullable|date',
            'partner_id'=>'nullable|exists:partners,id',
            'type' => 'nullable',
            'check_num' =>  'nullable',
        ];
    }
    public function messages()
    {
        return [
            'amount.nullable' =>'مبلغ رأس المال مطلوب',
            'amount.numeric' => 'مبلغ رأس المال لابد أن يكون رقم',

            'start_date.nullable' =>'تاريخ إضافة رأس المال مطلوب',
            'start_date.date' => 'أدخل قيمة صحيحة لتاريخ إضافة رأس المال',

            'partner_id.nullable' =>  'إسم الشريك مطلوب',
            'partner_id.exists' =>  'إسم الشريك الذي تم إدخالة غير موجود بقاعدة البيانات',
            'type' => 'إختر المصرف الذي تمت إضافة رأس المال اليه',

            'bank_id.nullable_if' =>  'إسم البنك مطلوب في حالة تم إضافة رأس المال الي البنك',
            'treasury_id.nullable_if' =>  'مطلوب في حالة تم إضافة رأس المال الي الخزينة',
        ];

    }



    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {
            DB::beginTransaction(); 

            $this->capital->update($data);

            $capitalAccount = Account::where('account_num',$this->capital->account_num)->first();
            $capitalAccount->current_balance = $this->capital->amount; 
            $capitalAccount->save();

            $this->reset(['amount','start_date','partner_id','type','bank_id','treasury_id','check_num']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayCapitals::class);

            // $this->dispatch(
            // 'alert',
            //     text: trans('admin.capital_updated_successfully'),
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')

            // );
            event(new NewCapitAlAddedEvent($this->capital));

            DB::commit();
            Alert::success('تم تعديل بيانات رأس المال بنجاح');
            return redirect()->route('capitals');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.capitals.update-capital');
    }
}
