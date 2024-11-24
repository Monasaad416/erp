<?php

namespace App\Livewire\Capitals;

use Alert;
use Exception;
use App\Models\Bank;
use App\Models\Account;
use App\Models\Capital;
use App\Models\Partner;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\JournalEntry;
use Illuminate\Validation\Rule;
use App\Events\NewPartnerCapital;
use Illuminate\Support\Facades\DB;
use App\Events\NewCapitAlAddedEvent;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Customers\DisplayCustomers;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddCapital extends Component
{
    public $amount,$start_date,$partner_id,$type,
    $bank_id,$treasury_id,$check_num;

    public function rules() {
        return [

            'amount' =>'required|numeric|min:0',
            'start_date' =>'required|date',
            'partner_id'=>'required|exists:partners,id|unique:capitals,partner_id',
            'type' => 'required',
            'bank_id' =>  'required_if:type,bank',
            'check_num' =>  'nullable',
            'treasury_id' =>  'required_if:type,treasury',
        ];
    }
    public function messages()
    {
        return [
            'amount.required' =>'مبلغ رأس المال مطلوب',
            'amount.numeric' => 'مبلغ رأس المال لابد أن يكون رقم',

            'start_date.required' =>'تاريخ إضافة رأس المال مطلوب',
            'start_date.date' => 'أدخل قيمة صحيحة لتاريخ إضافة رأس المال',

            'partner_id.required' =>  'إسم الشريك مطلوب',
            'partner_id.exists' =>  'إسم الشريك الذي تم إدخالة غير موجود بقاعدة البيانات',
            'partner_id.unique' =>  'إسم الشريك الذي تم إدخالة بالفعل يمتلك رأس مال في قاعدة البيانات',
            'type' => 'إختر المصرف الذي تمت إضافة رأس المال اليه',

            'bank_id.required_if' =>  'إسم البنك مطلوب في حالة تم إضافة رأس المال الي البنك',
            // 'check_num.required_if' =>  'رقم الشيك مطلوب في حالة تم إضافة رأس المال الي البنك',
            'treasury_id.required_if' =>  'مطلوب في حالة تم إضافة رأس المال الي الخزينة',
        ];

    }





    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        DB::beginTransaction();
        // try {



        $currentChildAccountNum = 0;

        $capitalsParentAccount = Account::where('account_num',31)->first();

        $latestAccountChild = Account::where('parent_id', $capitalsParentAccount->id)->latest()->first();
         //dd($latestAccountChild);
        if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
        } else {

            $currentChildAccountNum = $capitalsParentAccount->account_num . '0';
        }

       // dd($currentChildAccountNum);

        $capital = new Capital();
        $capital->amount = $this->amount;
        $capital->start_date = $this->start_date;
        $capital->partner_id = $this->partner_id;
        $capital->capitalizable_id = $this->type == "bank" ? $this->bank_id : $this->treasury_id;
        $capital->capitalizable_type = $this->type == "bank" ? 'App\Models\Bank' : 'App\Models\Treasury';
        $capital->check_num = $this->check_num;
        $capital->created_by = Auth::user()->id;
        $capital->account_num = $currentChildAccountNum + 1;
        $capital->save();


        //dd($$capital->partner->name);
        //إضافة حساب جديد لراس مال الشريك
        $account =  new Account();
        $account->name_ar="  رأس مال الشريك" ." " .$capital->partner->name;
        $account->account_num='32'.$capital->partner_id;
        $account->parent_account_num = 32;
        $account->start_balance=$capital->amount;
        $account->current_balance=$capital->amount;
        $account->created_by=1;
        $account->account_type_id=1;
        $account->notes ='رأس مال الشريك';
        $account->is_active=1;
        $account->is_parent=1;
        $account->parent_id=94;
        $account->branch_id= null;
        $account->nature="دائن";
        $account->list = "مركز-مالي";
        $account->level = 3 ;
        $account->is_parent = 0;
        $account->save();


        event(new NewCapitAlAddedEvent($capital));


        DB::commit();
        Alert::success('تم إضافة رأس مال جديد بنجاح');
        return redirect()->route('capitals');


        // } catch (Exception $e) {
        //      DB::rollback();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.capitals.add-capital');
    }
}
