<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Partner;
use App\Models\ClosingEntry;
use App\Models\PartnerWithdrawal;
use App\Models\IncomeListNetProfit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ClosingEntryForFinancialYear
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //Reveneues
        $salesBranchIncome = $event->salesBranchIncome ;
        $salesAssetsBranchIncome = $event->salesAssetsBranchIncome ;

        //Expenses
        $purchasesBranchIncome = $event->purchasesBranchIncome ;
        $salesReturnsBranchIncome =$event->salesReturnsBranchIncome;
        $waterBranchIncome =$event->waterBranchIncome;
        $electricityBranchIncome =$event->electricityBranchIncome  ;
        $phoneBranchIncome = $event->phoneBranchIncome ;
        $rentBranchIncome = $event->rentBranchIncome ;
        $internetBranchIncome = $event->internetBranchIncome ;
        $stationryBranchIncome = $event->stationryBranchIncome ;
        $transportationBranchIncome = $event->transportationBranchIncome ;
        $printersBranchIncome = $event->printersBranchIncome ;
        $salariesBranchIncome = $event->salariesBranchIncome ;
        $buildingsBranchDepIncome = $event->buildingsBranchDepIncome ;
        $carsBranchDepIncome = $event->carsBranchDepIncome ;
        $computersBranchDepIncome = $event->computersBranchDepIncome ;
        $furnitureBranchDepIncome = $event->furnitureBranchDepIncome ;
        $POSDevicesDepBranchIncome = $event->POSDevicesDepBranchIncome ;
        $taxBranchIncome = $event->taxBranchIncome ;

        $branch_id = $salesReturnsBranchIncome->branch_id ;
        $start_date = $salesReturnsBranchIncome->start_date ;
        $end_date = $salesReturnsBranchIncome->end_date ;
        
        


        //اغلاق المصروفات من حساب ملخص الدخل الي حساب المصروفات

        $debitParentAccount1 = Account::where('account_num',311)->first();// حساب ملخص الدخل
        $debitAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitParentAccount1->id)->where('branch_id',$branch_id)->first();
        //dd($debitAccount1);

        $purchasesCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$purchasesBranchIncome->name_ar)->first();
        $salesReturnsCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$salesReturnsBranchIncome->name_ar)->first();
        $waterCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$waterBranchIncome->name_ar)->first();
        $electricityeCrdit = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$stationryBranchIncome->name_ar)->first();
        $buildingsCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$buildingsBranchDepIncome->name_ar)->first();
        $carsCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$carsBranchDepIncome->name_ar)->first();
        $computersCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$computersBranchDepIncome->name_ar)->first();
        $furnitureCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$furnitureBranchDepIncome->name_ar)->first();
        $POSDevicesCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$electricityBranchIncome->name_ar)->first();
        $phoneCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$phoneBranchIncome->name_ar)->first();
        $rentCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$rentBranchIncome->name_ar)->first();
        $internetCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$internetBranchIncome->name_ar)->first();
        $stationryCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$POSDevicesDepBranchIncome->name_ar)->first();
        $transportationCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$transportationBranchIncome->name_ar)->first();
        $printersCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$printersBranchIncome->name_ar)->first();
        $salariesCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$salariesBranchIncome->name_ar)->first();
        $taxCreditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('name_ar',$taxBranchIncome->name_ar)->first();

        $entry = getNextClosingEntryNum();



        //dd($purchasesCreditAccount);
        // قيد اغلاق المخزون في حساب ملخص الدخل
        $entry1 = new ClosingEntry();
        $entry1->entry_num = $entry;
        $entry1->debit_account_num = $debitAccount1->account_num;
        $entry1->debit_account_id = $debitAccount1->id;
        $entry1->credit_account_num = $purchasesCreditAccount->account_num;
        $entry1->credit_account_id = $purchasesCreditAccount->id;
        $entry1->debit_amount = $purchasesBranchIncome->balance;
        $entry1->credit_amount = $purchasesBranchIncome->balance;
        $entry1->branch_id = $branch_id;
        $entry1->entry_type_id = 5 ;
        $entry1->created_by = Auth::user()->id;
        $entry1->updated_by = Auth::user()->id;
        $entry1->description = "/  من ح  $debitAccount1->name / إلي  ح  $purchasesCreditAccount->name";
        $entry1->start_date = $start_date;
        $entry1->end_date = $end_date;
        $entry1->save();

        // قيد اغلاق مردودات المبيعات في حساب ملخص الدخل
        $entry2 = new ClosingEntry();
        $entry2->entry_num = $entry;
        $entry2->debit_account_num = $debitAccount1->account_num;
        $entry2->debit_account_id = $debitAccount1->id;
        $entry2->credit_account_num = $salesReturnsCreditAccount->account_num;
        $entry2->credit_account_id = $salesReturnsCreditAccount->id;
        $entry2->debit_amount = $salesReturnsBranchIncome->balance;
        $entry2->credit_amount = $salesReturnsBranchIncome->balance;
        $entry2->branch_id = $branch_id;
        $entry2->entry_type_id = 5 ;
        $entry2->created_by = Auth::user()->id;
        $entry2->updated_by = Auth::user()->id;
        $entry2->description = "/  من ح  $debitAccount1->name / إلي  ح  $salesReturnsCreditAccount->name";
        $entry2->start_date = $start_date;
        $entry2->end_date = $end_date;
        $entry2->save();

        // قيد اغلاق استهلاك المياه في حساب ملخص الدخل
        $entry3 = new ClosingEntry();
        $entry3->entry_num = $entry;
        $entry3->debit_account_num = $debitAccount1->account_num;
        $entry3->debit_account_id = $debitAccount1->id;
        $entry3->credit_account_num = $waterCreditAccount->account_num;
        $entry3->credit_account_id = $waterCreditAccount->id;
        $entry3->debit_amount = $waterBranchIncome->balance;
        $entry3->credit_amount = $waterBranchIncome->balance;
        $entry3->branch_id = $branch_id;
        $entry3->entry_type_id = 5 ;
        $entry3->created_by = Auth::user()->id;
        $entry3->updated_by = Auth::user()->id;
        $entry3->description = "/  من ح  $debitAccount1->name / إلي  ح  $waterCreditAccount->name";
        $entry3->start_date = $start_date;
        $entry3->end_date = $end_date;
        $entry3->save();

        // قيد اغلاق استهلاك الكهرباء في حساب ملخص الدخل
        $entry4 = new ClosingEntry();
        $entry4->entry_num = $entry;
        $entry4->debit_account_num = $debitAccount1->account_num;
        $entry4->debit_account_id = $debitAccount1->id;
        $entry4->credit_account_num = $electricityeCrdit->account_num;
        $entry4->credit_account_id = $electricityeCrdit->id;
        $entry4->debit_amount = $electricityBranchIncome->balance;
        $entry4->credit_amount = $electricityBranchIncome->balance;
        $entry4->branch_id = $branch_id;
        $entry4->entry_type_id = 5 ;
        $entry4->created_by = Auth::user()->id;
        $entry4->updated_by = Auth::user()->id;
        $entry4->description = "/  من ح  $debitAccount1->name / إلي  ح  $electricityeCrdit->name";
        $entry4->start_date = $start_date;
        $entry4->end_date = $end_date;
        $entry4->save();

        // قيد اغلاق اهلاكات المباني  في حساب ملخص الدخل
        $entry5 = new ClosingEntry();
        $entry5->entry_num = $entry;
        $entry5->debit_account_num = $debitAccount1->account_num;
        $entry5->debit_account_id = $debitAccount1->id;
        $entry5->credit_account_num = $buildingsCreditAccount->account_num;
        $entry5->credit_account_id = $buildingsCreditAccount->id;
        $entry5->debit_amount = $buildingsBranchDepIncome->balance;
        $entry5->credit_amount = $buildingsBranchDepIncome->balance;
        $entry5->branch_id = $branch_id;
        $entry5->entry_type_id = 5 ;
        $entry5->created_by = Auth::user()->id;
        $entry5->updated_by = Auth::user()->id;
        $entry5->description = "/  من ح  $debitAccount1->name / إلي  ح  $buildingsCreditAccount->name";
        $entry5->start_date = $start_date;
        $entry5->end_date = $end_date;
        $entry5->save();

        // قيد اغلاق اهلاكات السيارات  في حساب ملخص الدخل
        $entry6 = new ClosingEntry();
        $entry6->entry_num = $entry;
        $entry6->debit_account_num = $debitAccount1->account_num;
        $entry6->debit_account_id = $debitAccount1->id;
        $entry6->credit_account_num = $carsCreditAccount->account_num;
        $entry6->credit_account_id = $carsCreditAccount->id;
        $entry6->debit_amount = $carsBranchDepIncome->balance;
        $entry6->credit_amount = $carsBranchDepIncome->balance;
        $entry6->branch_id = $branch_id;
        $entry6->entry_type_id = 5 ;
        $entry6->created_by = Auth::user()->id;
        $entry6->updated_by = Auth::user()->id;
        $entry6->description = "/  من ح  $debitAccount1->name / إلي  ح  $carsCreditAccount->name";
        $entry6->start_date = $start_date;
        $entry6->end_date = $end_date;
        $entry6->save();


        
        // قيد اغلاق اهلاكات اجهزة الكمبيوتر وغيرها  في حساب ملخص الدخل
        $entry7 = new ClosingEntry();
        $entry7->entry_num = $entry;
        $entry7->debit_account_num = $debitAccount1->account_num;
        $entry7->debit_account_id = $debitAccount1->id;
        $entry7->credit_account_num = $computersCreditAccount->account_num;
        $entry7->credit_account_id = $computersCreditAccount->id;
        $entry7->debit_amount = $computersBranchDepIncome->balance;
        $entry7->credit_amount = $computersBranchDepIncome->balance;
        $entry7->branch_id = $branch_id;
        $entry7->entry_type_id = 5 ;
        $entry7->created_by = Auth::user()->id;
        $entry7->updated_by = Auth::user()->id;
        $entry7->description = "/  من ح  $debitAccount1->name / إلي  ح  $computersCreditAccount->name";
        $entry7->start_date = $start_date;
        $entry7->end_date = $end_date;
        $entry7->save();

        // قيد اغلاق اهلاكات الاثاث في حساب ملخص الدخل
        $entry8 = new ClosingEntry();
        $entry8->entry_num = $entry;
        $entry8->debit_account_num = $debitAccount1->account_num;
        $entry8->debit_account_id = $debitAccount1->id;
        $entry8->credit_account_num = $furnitureCreditAccount->account_num;
        $entry8->credit_account_id = $furnitureCreditAccount->id;
        $entry8->debit_amount = $furnitureBranchDepIncome->balance;
        $entry8->credit_amount = $furnitureBranchDepIncome->balance;
        $entry8->branch_id = $branch_id;
        $entry8->entry_type_id = 5 ;
        $entry8->created_by = Auth::user()->id;
        $entry8->updated_by = Auth::user()->id;
        $entry8->description = "/  من ح  $debitAccount1->name / إلي  ح  $furnitureCreditAccount->name";
        $entry8->start_date = $start_date;
        $entry8->end_date = $end_date;
        $entry8->save();

        // قيد اغلاق اهلاكات الاثاث في حساب ملخص الدخل
        $entry9 = new ClosingEntry();
        $entry9->entry_num = $entry;
        $entry9->debit_account_num = $debitAccount1->account_num;
        $entry9->debit_account_id = $debitAccount1->id;
        $entry9->credit_account_num = $POSDevicesCreditAccount->account_num;
        $entry9->credit_account_id = $POSDevicesCreditAccount->id;
        $entry9->debit_amount = $POSDevicesDepBranchIncome->balance;
        $entry9->credit_amount = $POSDevicesDepBranchIncome->balance;
        $entry9->branch_id = $branch_id;
        $entry9->entry_type_id = 5 ;
        $entry9->created_by = Auth::user()->id;
        $entry9->updated_by = Auth::user()->id;
        $entry9->description = "/  من ح  $debitAccount1->name / إلي  ح  $POSDevicesCreditAccount->name";
        $entry9->start_date = $start_date;
        $entry9->end_date = $end_date;
        $entry9->save();
 
        // قيد اغلاق مصروفات الهاتف  في حساب ملخص الدخل
        $entry10 = new ClosingEntry();
        $entry10->entry_num = $entry;
        $entry10->debit_account_num = $debitAccount1->account_num;
        $entry10->debit_account_id = $debitAccount1->id;
        $entry10->credit_account_num = $phoneCreditAccount->account_num;
        $entry10->credit_account_id = $phoneCreditAccount->id;
        $entry10->debit_amount = $phoneBranchIncome->balance;
        $entry10->credit_amount = $phoneBranchIncome->balance;
        $entry10->branch_id = $branch_id;
        $entry10->entry_type_id = 5 ;
        $entry10->created_by = Auth::user()->id;
        $entry10->updated_by = Auth::user()->id;
        $entry10->description = "/  من ح  $debitAccount1->name / إلي  ح  $phoneCreditAccount->name";
        $entry10->start_date = $start_date;
        $entry10->end_date = $end_date;
        $entry10->save();

        // قيد اغلاق مصروفات الايجارات  في حساب ملخص الدخل
        $entry11 = new ClosingEntry();
        $entry11->entry_num = $entry;
        $entry11->debit_account_num = $debitAccount1->account_num;
        $entry11->debit_account_id = $debitAccount1->id;
        $entry11->credit_account_num = $rentCreditAccount->account_num;
        $entry11->credit_account_id = $rentCreditAccount->id;
        $entry11->debit_amount = $rentBranchIncome->balance;
        $entry11->credit_amount = $rentBranchIncome->balance;
        $entry11->branch_id = $branch_id;
        $entry11->entry_type_id = 5 ;
        $entry11->created_by = Auth::user()->id;
        $entry11->updated_by = Auth::user()->id;
        $entry11->description = "/  من ح  $debitAccount1->name / إلي  ح  $rentCreditAccount->name";
        $entry11->start_date = $start_date;
        $entry11->end_date = $end_date;
        $entry11->save();

        // قيد اغلاق مصروفات الانترنت  في حساب ملخص الدخل
        $entry12 = new ClosingEntry();
        $entry12->entry_num = $entry;
        $entry12->debit_account_num = $debitAccount1->account_num;
        $entry12->debit_account_id = $debitAccount1->id;
        $entry12->credit_account_num = $internetCreditAccount->account_num;
        $entry12->credit_account_id = $internetCreditAccount->id;
        $entry12->debit_amount = $internetBranchIncome->balance;
        $entry12->credit_amount = $internetBranchIncome->balance;
        $entry12->branch_id = $branch_id;
        $entry12->entry_type_id = 5 ;
        $entry12->created_by = Auth::user()->id;
        $entry12->updated_by = Auth::user()->id;
        $entry12->description = "/  من ح  $debitAccount1->name / إلي  ح  $internetCreditAccount->name";
        $entry12->start_date = $start_date;
        $entry12->end_date = $end_date;
        $entry12->save();

        // قيد اغلاق مصروفات الادوات المكتبية  في حساب ملخص الدخل
        $entry13 = new ClosingEntry();
        $entry13->entry_num = $entry;
        $entry13->debit_account_num = $debitAccount1->account_num;
        $entry13->debit_account_id = $debitAccount1->id;
        $entry13->credit_account_num = $stationryCreditAccount->account_num;
        $entry13->credit_account_id = $stationryCreditAccount->id;
        $entry13->debit_amount = $stationryBranchIncome->balance;
        $entry13->credit_amount = $stationryBranchIncome->balance;
        $entry13->branch_id = $branch_id;
        $entry13->entry_type_id = 5 ;
        $entry13->created_by = Auth::user()->id;
        $entry13->updated_by = Auth::user()->id;
        $entry13->description = "/  من ح  $debitAccount1->name / إلي  ح  $stationryCreditAccount->name";
        $entry13->start_date = $start_date;
        $entry13->end_date = $end_date;
        $entry13->save();

        // قيد اغلاق مصروفات الانتقالات  في حساب ملخص الدخل
        
        $entry14 = new ClosingEntry();
        $entry14->entry_num = $entry;
        $entry14->debit_account_num = $debitAccount1->account_num;
        $entry14->debit_account_id = $debitAccount1->id;
        $entry14->credit_account_num = $transportationCreditAccount->account_num;
        $entry14->credit_account_id = $transportationCreditAccount->id;
        $entry14->debit_amount = $transportationBranchIncome->balance;
        $entry14->credit_amount = $transportationBranchIncome->balance;
        $entry14->branch_id = $branch_id;
        $entry14->entry_type_id = 5 ;
        $entry14->created_by = Auth::user()->id;
        $entry14->updated_by = Auth::user()->id;
        $entry14->description = "/  من ح  $debitAccount1->name / إلي  ح  $transportationCreditAccount->name";
        $entry14->start_date = $start_date;
        $entry14->end_date = $end_date;
        $entry14->save();


        
        // قيد اغلاق مصروفات الطباعة  في حساب ملخص الدخل
        $entry15 = new ClosingEntry();
        $entry15->entry_num = $entry;
        $entry15->debit_account_num = $debitAccount1->account_num;
        $entry15->debit_account_id = $debitAccount1->id;
        $entry15->credit_account_num = $printersCreditAccount->account_num;
        $entry15->credit_account_id = $printersCreditAccount->id;
        $entry15->debit_amount = $printersBranchIncome->balance;
        $entry15->credit_amount = $printersBranchIncome->balance;
        $entry15->branch_id = $branch_id;
        $entry15->entry_type_id = 5 ;
        $entry15->created_by = Auth::user()->id;
        $entry15->updated_by = Auth::user()->id;
        $entry15->description = "/  من ح  $debitAccount1->name / إلي  ح  $printersCreditAccount->name";
        $entry15->start_date = $start_date;
        $entry15->end_date = $end_date;
        $entry15->save();

        
        // قيد اغلاق الاجور  في حساب ملخص الدخل
        $entry16 = new ClosingEntry();
        $entry16->entry_num = $entry;
        $entry16->debit_account_num = $debitAccount1->account_num;
        $entry16->debit_account_id = $debitAccount1->id;
        $entry16->credit_account_num = $salariesCreditAccount->account_num;
        $entry16->credit_account_id = $salariesCreditAccount->id;
        $entry16->debit_amount = $salariesBranchIncome->balance;
        $entry16->credit_amount = $salariesBranchIncome->balance;
        $entry16->branch_id = $branch_id;
        $entry16->entry_type_id = 5 ;
        $entry16->created_by = Auth::user()->id;
        $entry16->updated_by = Auth::user()->id;
        $entry16->description = "/  من ح  $debitAccount1->name / إلي  ح  $salariesCreditAccount->name";
        $entry16->start_date = $start_date;
        $entry16->end_date = $end_date;
        $entry16->save();

        // قيد اغلاق تسوية الضرائب  في حساب ملخص الدخل
        $entry17 = new ClosingEntry();
        $entry17->entry_num = $entry;
        $entry17->debit_account_num = $debitAccount1->account_num;
        $entry17->debit_account_id = $debitAccount1->id;
        $entry17->credit_account_num = $taxCreditAccount->account_num;
        $entry17->credit_account_id = $taxCreditAccount->id;
        $entry17->debit_amount = $taxBranchIncome->balance;
        $entry17->credit_amount = $taxBranchIncome->balance;
        $entry17->branch_id = $branch_id;
        $entry17->entry_type_id = 5 ;
        $entry17->created_by = Auth::user()->id;
        $entry17->updated_by = Auth::user()->id;
        $entry17->description = "/  من ح  $debitAccount1->name / إلي  ح  $taxCreditAccount->name";
        $entry17->start_date = $start_date;
        $entry17->end_date = $end_date;
        $entry17->save();



        
        //اغلاق الايردات من حساب الايرادات الي حساب  ملخص الدخل 

        //ايرادات المبيعات
        $salesDebitAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$salesBranchIncome->account_num)->where('branch_id',$branch_id)->first();
        
        // ايرادات بيع الاصول الثابتة
        $salesAssetsDebitAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$salesAssetsBranchIncome->account_num)->where('branch_id',$branch_id)->first();
        

        $creditAccountReveneus = $debitAccount1;
        //dd($creditAccountReveneus);

        // قيد اغلاق تسوية ايرادات المبيعات  في حساب ملخص الدخل
        $entry18 = new ClosingEntry();
        $entry18->entry_num = $entry;
        $entry18->debit_account_num = $salesDebitAccount->account_num;
        $entry18->debit_account_id = $salesDebitAccount->id;
        $entry18->credit_account_num = $creditAccountReveneus->account_num;
        $entry18->credit_account_id = $creditAccountReveneus->id;
        $entry18->debit_amount = $salesBranchIncome->balance;
        $entry18->credit_amount = $salesBranchIncome->balance;
        $entry18->branch_id = $branch_id;
        $entry18->entry_type_id = 5 ;
        $entry18->created_by = Auth::user()->id;
        $entry18->updated_by = Auth::user()->id;
        $entry18->description = "/  من ح  $salesDebitAccount->name / إلي  ح  $creditAccountReveneus->name";
        $entry18->start_date = $start_date;
        $entry18->end_date = $end_date;
        $entry18->save();

       // قيد اغلاق تسوية ايرادات  مبيعات الاصول الثابتة  في حساب ملخص الدخل
        $entry19 = new ClosingEntry();
        $entry19->entry_num = $entry;
        $entry19->debit_account_num = $salesAssetsDebitAccount->account_num;
        $entry19->debit_account_id = $salesAssetsDebitAccount->id;
        $entry19->credit_account_num = $creditAccountReveneus->account_num;
        $entry19->credit_account_id = $creditAccountReveneus->id;
        $entry19->debit_amount = $salesAssetsBranchIncome->balance;
        $entry19->credit_amount = $salesAssetsBranchIncome->balance;
        $entry19->branch_id = $branch_id;
        $entry19->entry_type_id = 5 ;
        $entry19->created_by = Auth::user()->id;
        $entry19->updated_by = Auth::user()->id;
        $entry19->description = "/  من ح  $salesAssetsDebitAccount->name / إلي  ح  $creditAccountReveneus->name";
        $entry19->start_date = $start_date;
        $entry19->end_date = $end_date;
        $entry19->save();



        $grossProfit = $entry18->debit_amount + $entry19->debit_amount; //مبيعات + بيع الاصول الثابتة
        //dd($grossProfit);
        $expenses = $entry1->debit_amount + $entry2->debit_amount + $entry3->debit_amount + $entry4->debit_amount + $entry5->debit_amount +
            $entry6->debit_amount + $entry7->debit_amount + $entry8->debit_amount + $entry9->debit_amount + $entry10->debit_amount +
            $entry11->debit_amount + $entry12->debit_amount + $entry13->debit_amount + $entry14->debit_amount + $entry15->debit_amount
            + $entry16->debit_amount + $entry17->debit_amount ;


        $netProfit = new IncomeListNetProfit();
        $netProfit->profit = $grossProfit - $expenses;

        $netProfit->start_date = $entry1->start_date;
        $netProfit->end_date = $entry1->end_date;
        $netProfit->branch_id = $entry->branch_id;
        $netProfit->save();



        //أغلاق المسحوبات الشخصية في حساب رأس مال الشريك
        $debitAccount2Parent = Account::where('account_num', 32)->first();//جاري الشركاء والمساهمين
        $creditAccountParent2 = Account::where('account_num',35)->first();//مسحوبات الشركاء
        $creditAccounts = Account::where('parent_account_num', $creditAccountParent2->account_num)->get();


        foreach($creditAccounts as $creditAccount2) {
            $accountNumber = $creditAccount2->account_num;
            $debitAccount2 = Account::where('account_num',$accountNumber)->first(); //حساب المسحوبات الشخصية الخاص بالشريك 

            $partner = Partner::where('account_num',$creditAccount2->account_num)->first();
            $partnerWithdrawal = PartnerWithdrawal::where('partner_id',$partner->id)->whereYear('date')->sum('amount');

            ClosingEntry::create([
                'entry_num' => $entry,
                'debit_account_num' => $debitAccount2->account_num,
                'debit_account_id' => $debitAccount2->id,
                'credit_account_num' => $creditAccount2->account_num,
                'credit_account_id' => $creditAccount2->id,
                'debit_amount' => $partnerWithdrawal,
                'credit_amount' => $partnerWithdrawal,
                'branch_id' => $branch_id,
                'entry_type_id' => 5,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'description' => "/  من ح  $debitAccount2->name / إلي  ح  $creditAccount2->name",
                'start_date' => $entry1->end_date,
                'end_date' => $entry1->start_date,
            ]);

        }
        


       // dd($entry18,$entry19);

        


        
    }
}
