<?php

namespace App\Jobs;

use App\Models\Asset;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\TAccount;
use App\Models\Depreciation;
use App\Models\JournalEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddAssetDepreciation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
                //     public function getNextJournalEntryNum()
                // {
                //     $entryNum = journalEntry::max('entry_num');
                //     if($entryNum) {
                //         return $entryNum + 1;
                //     }

                //     return '1';
                // }
    public function handle(): void
    {


        try {
            $currentYear = Carbon::now()->year;
            $endDate = Carbon::createFromDate($currentYear, 12, 31)->toDateString();
            dd($currentYear);

            $depreciations = Depreciation::whereDate('date', $endDate)->get();

            //dd($depreciations);
            foreach ($depreciations as $dep) {
                //dd($dep->asset_id);
                $asset = Asset::where('id',$dep->asset_id)->first();
                $parentAssetAccountName = Account::where('id',$asset->parent_account_id)->first()->name_ar;
                $relatedAccounts = Account::where('name_ar','like','%'. $parentAssetAccountName .'%')->get();
              // dd($parentAssetAccountName);


                $entry = getNextJournalEntryNum();
               // dd($entry);

                $filteredDebitAccount = $relatedAccounts->first(function ($account) {
                    return strpos($account->name_ar, 'مخصص') === 0;
                });

                $filteredCreditAccount = $relatedAccounts->first(function ($account) {
                    return strpos($account->name_ar, 'مصروفات اهلاك') === 0;
                });
               //dd($filteredCreditAccount);
                $debitAccount2 =  Account::where('account_num',$filteredDebitAccount->account_num)->first();

                $creditAccount2 =  Account::where('account_num',$filteredCreditAccount->account_num)->first();
            //dd($creditAccount2->name,$debitAccount2->name);



                //تسجيل مخصص الاهلاك -مصروفات الاهلاك
                $entry2 = new JournalEntry();

                $entry2->entry_num = $entry;
                $entry2->debit_account_num = $debitAccount2->account_num;
                $entry2->debit_account_id = $debitAccount2->id;
                $entry2->credit_account_num = $creditAccount2->account_num;
                $entry2->credit_account_id = $creditAccount2->id;
                $entry2->debit_amount = $dep->amount;
                $entry2->credit_amount = $dep->amount;
                $entry2->branch_id = $asset->branch_id;
                $entry2->jounralable_type = 'App\Models\Asset';
                $entry2->jounralable_id = $asset->id;
                $entry2->entry_type_id = 1 ;
                $entry2->created_by = $asset->created_by;
                $entry2->updated_by = $asset->created_by;
                $entry2->description  = "من ح  /  $debitAccount2->name_ar   الي ح / $creditAccount2->name_ar " ;
                $entry2->date = $asset->purchase_date;
                $entry2->save();

                //dd($entry2);



                $debitAccount2->current_balance = $debitAccount2->current_balance + $entry2->debit_amount;
                $debitAccount2->save();


                //الاستاذ العام لمخصص الاهلاك مدين
                $ledger2 = new Ledger();
                $ledger2->debit_amount = $entry2->debit_amount;
                $ledger2->credit_amount = 0 ;
                $ledger2->account_id = $debitAccount2->id;
                $ledger2->account_num = $debitAccount2->account_num;
                $ledger2->created_by = Auth::user()->id;
                $ledger2->date = $asset->purchase_date;
                $ledger2->save();


                //الاستاذ العام لمصروفات الاهلاك دائن
                $ledger4 = new Ledger();
                $ledger4->debit_amount = 0;
                $ledger4->credit_amount = $entry2->credit_amount;
                $ledger4->account_id = $creditAccount2->id;
                $ledger4->account_num = $creditAccount2->account_num;
                $ledger4->created_by = Auth::user()->id;
                $ledger4->date = $asset->purchase_date;
                $ledger4->save();



            // الاستاذ لمخصص الاهلاك  مدين
                $tAccount2 = new TAccount();
                $tAccount2->serial_num = getNextTAccountSerial();
                $tAccount2->account_num = $entry2->debit_account_num;
                $tAccount2->journal_type = 'مدين';
                $tAccount2->amount = $entry2->debit_amount;
                $tAccount2->description =  "   الي ح / $creditAccount2->name";
                $tAccount2->journal_entry_id = $entry2->id;
                $tAccount2->account_id = $debitAccount2->id;
                $tAccount2->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
                $tAccount2->created_by = Auth::user()->id;
                $tAccount2->save();



                //الاستاذ لمصروفات الاهلاك  دائن
                $tAccount4 = new TAccount();
                $tAccount4->serial_num = getNextTAccountSerial();
                $tAccount4->account_num = $entry2->credit_account_num;
                $tAccount4->journal_type = 'دائن';
                $tAccount4->amount = $entry2->credit_amount;
                $tAccount4->description  = "من ح/  $debitAccount2->name";
                $tAccount4->journal_entry_id = $entry2->id;
                $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->created_by = Auth::user()->id;
                $tAccount4->save();
        }
            } catch (\Exception $e) {
        Log::error('Job failed: ' . $e->getMessage());
    }

    }
}
