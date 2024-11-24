<?php

namespace App\Livewire\JournalEntries;

use Exception;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\Customer;
use App\Models\AccountType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Customers\DisplayCustomers;

class AddEntry extends Component
{
    public $debit,$credit,$debit_amount,$credit_amount;


    public function rules() {
        return [
            'debit' => 'required|exists:accounts,id|different:credit',
            'credit' => 'required|exists:accounts,id|different:debit',
            'debit_amount' => 'required|numeric',
            'credit_amount' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'debit.required' => 'حساب المدين مطلوب',
            'debit.exists' => 'حساب المدين الذي تم إدخاله غير موجود بقاعدة البيانات',

            'credit.required' => 'حساب الدائن مطلوب',
            'credit.exists' => 'حساب الدائن الذي تم إدخاله غير موجود بقاعدة البيانات',

            'debit_amount.required' => 'مبلغ المدين مطلوب',
            'debit_amount.numeric' => 'مبلغ المدين يجب أن يكون رقم',

            'credit_amount.required' => 'مبلغ الدائن مطلوب',
            'credit_amount.numeric' => 'مبلغ الدائن يجب أن يكون رقم',


        ];

    }






    public function create()
    {
          $this->validate($this->rules() ,$this->messages());
          dd($this->all());
          DB::beginTransaction();
        try {


          //قيد اليومية
            //تسجيل   الخزينة مدين -راس المال دائن
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $capital->amount;
            $entry1->credit_amount = $capital->amount;
            $entry1->branch_id = $treasury->branch_id;
            $entry1->jounralable_type = 'App\Models\Capital';
            $entry1->jounralable_id = $capital->id;
            $entry1->entry_type_id = 1 ;
            $entry1->created_by = $capital->created_by;
            $entry1->description = " من ح /  " . $debitAccount->name . "  الي ح   /  ".  $creditAccount->name  ;
            $entry1->date = $capital->start_date;
            $entry1->save();

             //تحديث رصيد حساب الخزينة وراس المال
            // $debitAccount->current_balance = $debitAccount->current_balance + $entry1->debit_amount;
            // $debitAccount->save();

            //الاستاذ العام للخزينة مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->date = $entry1->date;
            $ledger1->save();

            //الاستاذ العام لراس المال دائن
            $ledger2 = new Ledger();
            $ledger2->debit_amount = 0;
            $ledger2->credit_amount = $entry1->credit_amount;
            $ledger2->account_id = $creditAccount->id;
            $ledger2->account_num = $creditAccount->account_num;
            $ledger2->created_by = $capital->created_by;
            $ledger2->name_ar = $creditAccount->name;
            $ledger2->date = $entry1->date;
            $ledger2->save();

            //الاستاذ المساعد للخزينة مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = " الي ح / ". $creditAccount->name  ;
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            $tAccount1->created_by = $capital->created_by;
            $tAccount1->save();

            //الاستاذ راس المال دائن
            $tAccount2 = new TAccount();
            $tAccount2->serial_num = getNextTAccountSerial();
            $tAccount2->account_num = $entry1->credit_account_num;
            $tAccount2->journal_type = 'دائن';
            $tAccount2->amount = $entry1->credit_amount;
            $tAccount2->description = "من ح  / " . $debitAccount->name;
            $tAccount2->journal_entry_id = $entry1->id;
            $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount2->created_by = Auth::user()->id;
            $tAccount2->save();


        $this->reset(['credit1','debit','debit_amount','credit_amount']);

        $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayCustomers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.customer_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );

            DB::commit();
        } catch (Exception $e) {
             DB::rollback();
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.journal-entries.add-entry');
    }
}
