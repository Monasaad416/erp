<?php

namespace App\Exports;

use App\Models\Ledger;
use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromCollection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AccountsExport implements FromCollection
{
    public $from_date,$to_date,$searchItem,$levels=[];
        public function __construct($from_date,$to_date,$searchItem,$levels=[])
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->searchItem = $searchItem;
        $this->levels = $levels;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $accounts = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'account_num')
            ->where(function ($query) {
                if (!empty($this->searchItem)) {
                    $query->where('name_'.LaravelLocalization::getCurrentLocale(), 'like', '%'.$this->searchItem.'%')
                        ->orWhere('account_num', 'like', '%'.$this->searchItem.'%');
                }
                if (!empty($this->levels)) {
                    $query->whereIn('level',$this->levels );
                }
                // if ($this->from_date != null && $this->to_date != null) {
                //     $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                // }
            })->get();
            return $accounts;
          
        }

  public function map($account): array
{
    $accountsQuery = Ledger::select(
        'id',
        'name_'.LaravelLocalization::getCurrentLocale().' as name',
        'debit_amount',
        'credit_amount',
        'account_num'
    )
    ->where('account_num', $account->account_num)
    ->where(function ($query) use ($account) {
        if (!empty($this->searchItem)) {
            $query->where('name_'.LaravelLocalization::getCurrentLocale(), 'like', '%'.$this->searchItem.'%')
                ->orWhere('account_num', 'like', '%'.$this->searchItem.'%');
        }

        if ($this->from_date != null && $this->to_date != null) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }
    });

    $totalDebit = $accountsQuery->sum('debit_amount');
    $totalCredit = $accountsQuery->sum('credit_amount');
    
    return [
        $account->name,
        $account->account_num,
        $totalDebit,
        $totalCredit,
        $totalDebit - $totalCredit
    ];
}
        public function headings(): array
        {
              return [
                'الاسم',
                'رقم الحساب',
                'المدين',
                'الدائن',
                'الرصيد',
            ];
        }
}
