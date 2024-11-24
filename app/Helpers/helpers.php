<?php

use Carbon\Carbon;
use App\Models\Ledger;

use App\Models\Account;
use App\Models\Customer;
use App\Models\TAccount;
use App\Models\Transaction;
use App\Models\ClosingEntry;
use App\Models\JournalEntry;
use App\Models\InventoryCount;
use App\Models\SupplierInvoice;


     function getNextInvoiceNumber()
    {
        // $year = Carbon::now()->year;
        $currentInvoiceNumber = SupplierInvoice::withTrashed()->max('supp_inv_num');
        if($currentInvoiceNumber) {
            return $currentInvoiceNumber + 1;
        }

        return '1';
    }


    function getNextInvCountNum()
    {
        $year = Carbon::now()->year;
        $currentInvCount = InventoryCount::whereYear('created_at',$year)->max('inv_count_num');
        if($currentInvCount) {
            return $currentInvCount + 1;
        }

        return $year. '0000001';
    }



    function getNextJournalEntryNum()
    {
        $entryNum = journalEntry::max('entry_num');
        if($entryNum) {
            return $entryNum + 1;
        }

        return '1';
    }

    function getNextClosingEntryNum()
    {
        $entryNum = ClosingEntry::max('entry_num');
        if($entryNum) {
            return $entryNum + 1;
        }

        return '1';
    }

    function getNextSerial()
    {
        $currentSerial = SupplierInvoice::max('serial_num');
        if($currentSerial) {
            return $currentSerial + 1;
        }
        return 1;
    }

    function getNextTAccountSerial()
    {
        $currentTAccountSerial = TAccount::max('serial_num');
        if($currentTAccountSerial) {
            return $currentTAccountSerial + 1;
        }
        return 1 ;
    }

    function getNextTransSerial()
    {
        $currentSerial = Transaction::max('serial_num');
        if($currentSerial) {
            return $currentSerial + 1;
        }
        return '1';
    }

    function getNextCustomerCode()
    {
        $customerNum = Customer::max('code');
        if($customerNum) {
            return $customerNum + 1;
        }

        return '1';
    }




    // function getYearLedgers($branch_id,$start_date,$end_date)
    // {
    //     $purchasesParent = Account::where('account_num',1224)->where('name_ar','المخزون')->first();
    //     $salesParent = Account::where('account_num',41)->where('name_ar','ايرادات مبيعات')->first();
    //     $salesAssetsParent = Account::where('account_num',44)->first();//ايردات بيع الاصول الثابتة
    //     $salesReturnParent = Account::where('account_num',42)->where('name_ar','مردودات ومسموحات مبيعات')->first();
    //     $waterParent = Account::where('account_num',5111)->where('name_ar',"استهلاك المياة")->first();
    //     $electricityParent = Account::where('account_num',5112)->where('name_ar',"استهلاك الكهرباء")->first();
    //     $phoneParent = Account::where('account_num',5113)->where('name_ar',"  استهلاك هاتف")->first();
    //     $rentParent = Account::where('account_num',5114)->where('name_ar', "ايجار")->first();
    //     $internetParent = Account::where('account_num',5115)->where('name_ar', "انترنت")->first();
    //     $stationryParent = Account::where('account_num',5116)->where('name_ar', "ادوات مكتبية")->first();
    //     $transportaionParent = Account::where('account_num',5117)->where('name_ar',  "انتقالات")->first();
    //     $printersParent = Account::where('account_num',5119)->where('name_ar',  "طباعة واحبار")->first();
    //     $salariesParent = Account::where('account_num',513)->first();
    //     $buildingsDepreciationsParent = Account::where('account_num',5121)->first();//اهلاكات المباني
    //     $carsDepreciationsParent = Account::where('account_num',5122)->first();//اهلاكات السيارات
    //     $computersDepreciationsParent = Account::where('account_num',5123)->first();//اهلاكات اجهزة الكمبيوتر وغيرها
    //     $furnitureDepreciationsParent = Account::where('account_num',5124)->first();//اهلاكات الاثاثات
    //     $posDevicesDepreciationsParent = Account::where('account_num',5125)->first();//اهلاكات اجهزة الدفع الالكتروني
    //     $taxesParent = Account::where('account_num',2232)->first();

    //     $purchasesBranch =  Account::where('parent_id',$purchasesParent->id)->where('branch_id',$branch_id)->first();
    //     $salesBranch =  Account::where('parent_id',$salesParent->id)->where('branch_id',$branch_id)->first();
    //     $salesAssetsBranch =  Account::where('parent_id',$salesAssetsParent->id)->where('branch_id',$branch_id)->first();
    //     $salesReturnsBranch =  Account::where('parent_id',$salesReturnParent->id)->where('branch_id',$branch_id)->first();
    //     $waterBranch =  Account::where('parent_id',$waterParent->id)->where('branch_id',$branch_id)->first();
    //     $electricityBranch =  Account::where('parent_id',$electricityParent->id)->where('branch_id',$branch_id)->first();
    //     $phoneBranch =  Account::where('parent_id',$phoneParent->id)->where('branch_id',$branch_id)->first();
    //     $rentBranch =  Account::where('parent_id',$rentParent->id)->where('branch_id',$branch_id)->first();
    //     $internetBranch =  Account::where('parent_id',$internetParent->id)->where('branch_id',$branch_id)->first();
    //     $stationryBranch =  Account::where('parent_id',$stationryParent->id)->where('branch_id',$branch_id)->first();
    //     $transportationBranch =  Account::where('parent_id',$transportaionParent->id)->where('branch_id',$branch_id)->first();
    //     $printerBranch =  Account::where('parent_id',$printersParent->id)->where('branch_id',$branch_id)->first();
    //     $salariesBranch =  Account::where('parent_id',$salariesParent->id)->whereNot('branch_id',1)->where('branch_id',$branch_id)->first();
    //     $buildingsDepreciationsBranch =  Account::where('parent_id',$buildingsDepreciationsParent->id)->where('branch_id',$branch_id)->first();
    //     $carsDepreciationsBranch =  Account::where('parent_id',$carsDepreciationsParent->id)->where('branch_id',$branch_id)->first();
    //     $computersDepreciationsBranch =  Account::where('parent_id',$computersDepreciationsParent->id)->where('branch_id',$branch_id)->first();
    //     $furnitureDepreciationsBranch =  Account::where('parent_id',$furnitureDepreciationsParent->id)->where('branch_id',$branch_id)->first();
    //     $posDevicesDepreciationsBranch =  Account::where('parent_id',$posDevicesDepreciationsParent->id)->where('branch_id',$branch_id)->first();
    //     $taxesBranch =  Account::where('parent_id',$taxesParent->id)->where('branch_id',$branch_id)->first();

    //     $purchasesBranchLedger = Ledger::where('account_id',$purchasesBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $salesBranchLedger = Ledger::where('account_id',$salesBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $salesAssetsBranchLedger = Ledger::where('account_id',$salesAssetsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $salesReturnsBranchLedger = Ledger::where('account_id',$salesReturnsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $waterBranchLedger = Ledger::where('account_id',$waterBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $electricityBranchLedger = Ledger::where('account_id',$electricityBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $phoneBranchLedger = Ledger::where('account_id',$phoneBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $rentBranchLedger = Ledger::where('account_id',$rentBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $internetBranchLedger = Ledger::where('account_id',$internetBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $stationryBranchLedger = Ledger::where('account_id',$stationryBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $transportationBranchLedger = Ledger::where('account_id',$transportationBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $printerBranchLedger = Ledger::where('account_id',$printerBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     if($branch_id != 1) {
    //         $salariesBranchLedger = Ledger::where('account_id',$salariesBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     }
    //     // dd($salariesBranchLedger);
    //     $buildingsDepreciationsBranchLedger = Ledger::where('account_id',$buildingsDepreciationsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $carsDepreciationsBranchLedger = Ledger::where('account_id',$carsDepreciationsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $computersDepreciationsBranchLedger = Ledger::where('account_id',$computersDepreciationsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $furnitureDepreciationsBranchLedger = Ledger::where('account_id',$furnitureDepreciationsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $posDevicesDepreciationsBranchLedger = Ledger::where('account_id',$posDevicesDepreciationsBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();
    //     $taxesBranchLedger = Ledger::where('account_id',$taxesBranch->id)->whereBetween('created_at',[$start_date,$end_date])->get();

    //     return [$purchasesBranchLedger,$taxesBranch];

    // }
