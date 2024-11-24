<?php

namespace App\Livewire\TrailBalancesBefore;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\TrailBalanceBefore;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddTrailBalanceBefore extends Component
{
        public $start_date,$end_date,$branch_id;

    public function rules() {
        return [
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'branch_id' => 'required|exists:branches,id',
        ];

    }

    public function messages()
    {
        return [
            'start_date.required' => 'تاريخ بداية إصدار ميزان المراجعة مطلوب',
            'start_date.date' => 'أدخل صيغة صحيحة لتاريخ بداية إصدار ميزان  ',
            'start_date.before' => 'تاريخ بداية ميزان المراجعة يجب أن يكون قبل تاريخ نهاية الميزان',
            'end_date.required' => 'تاريخ نهاية إصدار ميزان المراجعة مطلوب',
            'end_date.date' => 'أدخل صيغة صحيحة لتاريخ نهاية إصدار ميزان  ',
            'end_date.before' =>  'تاريخ نهاية ميزان المراجعة يجب أن يكون بعد تاريخ بداية  الميزان',
            'branch_id.required' => 'اختر الفرع المطلوب  إصدار ميزان المراجعة له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',
        ];

    }

    public function mount()
    {
        $currentYear = Carbon::now()->format('Y');
        $this->start_date = $currentYear.'-01-01';
        $this->end_date = $currentYear.'-12-31';

        // dd($this->start_date, $this->end_date);
    }

    public function create()
    {

        $this->validate($this->rules() ,$this->messages());
    //    dd("kk");
        // DB::beginTransaction();
        // try {

        // return dd($this->all());



// dd(Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num', 'level', 'is_parent')->where('branch_id',$this->branch_id)
//                 ->whereNot('account_num','like','311' .'%')->get());

            foreach(Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num', 'level', 'is_parent')->where('branch_id',$this->branch_id)
                ->whereNot('account_num','like','311' .'%')->get() as $account ) {
                    $ledgers = Ledger::where('account_num',$account->account_num)
                    ->where('type','journal_entry')
                    ->where(function ($query) {
                        if ($this->start_date != null && $this->end_date != null) {
                            $query->whereBetween('date', [$this->start_date, $this->end_date]);
                        }
                    })->get();


                    $parentAccountsLevel2 = Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num', 'level', 'is_parent')
                    ->where('account_num', "=",substr($account->account_num, 0, 2))->first();

                    $parentAccountsLevel3 = Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num', 'level', 'is_parent')
                    ->where('account_num', "=", substr($account->account_num, 0, 3))->first();

                
                    //dd($parentlevel3AccountNum);

                    $totalDebitForAllLevelAccounts = 0;
                    $totalCreditForAllLevelAccounts = 0;

                    $totalDebitForOneAccount = $ledgers->sum('debit_amount');
                    $totalCreditForOneAccount = $ledgers->sum('credit_amount');

                    $totalDebitForAllLevelAccounts += $totalDebitForOneAccount;
                    $totalCreditForAllLevelAccounts += $totalCreditForOneAccount;
                    //dd($parentAccountsLevel3->account_num);

                    $trailBalance1 = TrailBalanceBefore::where('start_date',$this->start_date)
                    ->where('end_date',$this->end_date)->where('branch_id',$this->branch_id)
                    ->where('account_num', "=", $account->account_num)->first();

 //dd($trailBalance1);
                    if($trailBalance1 !=null){
                        $trailBalance1->update([
                            'debit' =>$totalDebitForOneAccount,
                            'credit' =>$totalCreditForOneAccount,
                        ]);
                    } else {


                    // dd($totalDebitForAllLevelAccounts, $totalCreditForAllLevelAccounts);
                    $newTrailBalance1 = new TrailBalanceBefore();
                    $newTrailBalance1->account_id =  $account->id;
                    $newTrailBalance1->account_num =  $account->account_num;
                    $newTrailBalance1->debit = $totalDebitForAllLevelAccounts;
                    $newTrailBalance1->credit = $totalCreditForAllLevelAccounts;
                    $newTrailBalance1->balance = $totalDebitForAllLevelAccounts - $totalCreditForAllLevelAccounts;
                    $newTrailBalance1->start_date =  $this->start_date;
                    $newTrailBalance1->end_date =  $this->end_date;
                    $newTrailBalance1->name_ar = $account->name;
                    $newTrailBalance1->name_en = $account->name;
                    $newTrailBalance1->branch_id = $this->branch_id;
                    $newTrailBalance1->save();
                    }



            }


            if($this->branch_id == 1) {

                foreach(Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num', 'level', 'is_parent')
                ->where('account_num','like','221'.'%')
                ->where('is_parent',0)->get() as $supplierAccount) {

                        $ledgers = Ledger::where('account_num', $supplierAccount->account_num)
                            ->where('type', 'journal_entry')
                            ->where(function ($query) {
                                if ($this->start_date != null && $this->end_date != null) {
                                    $query->whereBetween('date', [$this->start_date, $this->end_date]);
                                }
                            })->get();

                    // dd($ledgers);

                    $totalDebitForOneAccount = $ledgers->sum('debit_amount');
                    $totalCreditForOneAccount = $ledgers->sum('credit_amount');
                    //dd($totalDebitForOneAccount, $totalCreditForOneAccount);

                    $trailBalance2 = TrailBalanceBefore::where('account_num', $supplierAccount->account_num)->where('start_date', $this->start_date)
                        ->where('end_date', $this->end_date)->first();
                    if ($trailBalance2) {
                        $trailBalance2->update([
                            'debit' => $totalDebitForOneAccount,
                            'credit' => $totalCreditForOneAccount,
                        ]);
                    } else {
                        $newTrailBalance2 = new TrailBalanceBefore();
                        $newTrailBalance2->account_id =  $supplierAccount->id;
                        $newTrailBalance2->account_num =  $supplierAccount->account_num;
                        $newTrailBalance2->debit = $totalDebitForOneAccount;
                        $newTrailBalance2->credit = $totalCreditForOneAccount;
                        $newTrailBalance2->balance = $totalDebitForOneAccount - $totalCreditForOneAccount;
                        $newTrailBalance2->start_date =  $this->start_date;
                        $newTrailBalance2->end_date =  $this->end_date;
                        $newTrailBalance2->name_ar = $supplierAccount->name;
                        $newTrailBalance2->name_en = $supplierAccount->name;
                        $newTrailBalance2->branch_id = 1;
                        $newTrailBalance2->save();
                        }


                }
            }
            $this->reset(['start_date','end_date','branch_id']);



            //dispatch browser events (js)
            //add event to toggle create modal after save
            $this->dispatch('createModalToggle');

            DB::commit();
            Alert::success('تم إضافة ميزان المراجعة للفرع بنجاح');
            return redirect()->route('trail_balance_before');
        // } catch (Exception $e) {
        //     DB::rollback();
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }



    }


    public function render()
    {
        return view('livewire.trail-balances-before.add-trail-balance-before');
    }
}
