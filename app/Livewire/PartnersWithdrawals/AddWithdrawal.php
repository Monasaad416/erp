<?php

namespace App\Livewire\PartnersWithdrawals;

use App\Events\NewPartnerWithdrawal;
use App\Models\Account;
use Livewire\Component;
use App\Models\PartnerWithdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Alert;

class AddWithdrawal extends Component
{
    public $amount,$date,$partner_id,$type,
    $bank_id,$treasury_id,$sourcable_id;

    public function rules() {
        return [
            'amount' =>'required|numeric|min:0',
            'date' =>'required|date',
            'partner_id'=>'required|exists:partners,id',
            'type' => 'required',
            'sourcable_id'=>'required|in:treasury,bank',
        ];
    }
    public function messages()
    {
        return [
            'amount.required' =>'مبلغ السحب مطلوب',
            'amount.numeric' => 'مبلغ السحب لابد أن يكون رقم',

            'date.required' =>'تاريخ سحب المبلغ مطلوب',
            'date.date' => 'أدخل قيمة صحيحة لتاريخ السحب',

            'partner_id.required' =>  'إسم الشريك مطلوب',
            'partner_id.exists' =>  'إسم الشريك الذي تم إدخالة غير موجود بقاعدة البيانات',

            'type' => 'إختر الغرض من عملية السحب',
        ];
    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
       
        DB::beginTransaction();
        // try {

        $partnerWithdrawal = new PartnerWithdrawal();
        $partnerWithdrawal->amount = $this->amount;
        $partnerWithdrawal->date = $this->date;
        $partnerWithdrawal->partner_id = $this->partner_id;
        $partnerWithdrawal->sourcable_id = $this->sourcable_id == "bank" ? $this->bank_id : $this->treasury_id;
        $partnerWithdrawal->sourcable_type = $this->type == "bank" ? 'App\Models\Bank' : 'App\Models\Treasury';
        $partnerWithdrawal->created_by = Auth::user()->id;
        $partnerWithdrawal->save();
        

        event(new NewPartnerWithdrawal($partnerWithdrawal));
     

        DB::commit();
        Alert::success('تم إضافة مسحوبات جديدة بنجاح');
        return redirect()->route('partners.withdrawals');

    }
    public function render()
    {
        return view('livewire.partners-withdrawals.add-withdrawal');
    }
}
