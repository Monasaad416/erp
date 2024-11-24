<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Zatca\CsrController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ZatcaController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Zatca\PublicKeyController;
use App\Http\Controllers\Zatca\PrivateKeyController;
use App\Http\Controllers\Admin\AmountStateController;
use App\Http\Controllers\Admin\NotificationController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
        Route::view('/confirm_shift_delivery','admin.pages.treasury_shifts.confirm_shift_delivery')->name('confirm_shift_delivery_first');
//,'auto_check_permission'
Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
    
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth','check_shift_delivery' ]
], function(){


       Route::redirect('/', '/ar');

        //Home Page//
        Route::get('/',[HomeController::class,'index'])->name('index');
        // Route::get('/zatca',[ZatcaController::class,'test'])->name('test');


        //livewire//


        Route::view('/settings/edit','admin.pages.settings.edit')->name('settings.edit');
        Route::view('/capital/settings/edit','admin.pages.capital_settings.edit')->name('capital_settings.edit');

        Route::view('/financial-years','admin.pages.financial_years.index')->name('financial_years');
        Route::view('/financial-months','admin.pages.financial_months.index')->name('financial_months');

        Route::view('/assets','admin.pages.assets_list.index')->name('assets');
        Route::view('/assets/depreciations','admin.pages.depreciations.index')->name('assets.depreciations');
        Route::view('/assets/suppliers','admin.pages.assets_suppliers.index')->name('assets_suppliers');
        Route::view('/assets/sales','admin.pages.assets_sales.index')->name('assets_sales');




        Route::view('/capital/partners','admin.pages.capitals.partners')->name('partners');
        Route::view('/capital/devision','admin.pages.capitals_devision')->name('capitals.devision');
        Route::view('/capital/capitals-list','admin.pages.capitals.capitals')->name('capitals');
        Route::view('/capital/partners-withdrawals','admin.pages.capitals.partners_withdrawals')->name('partners.withdrawals');


        Route::view('/users/rewards','admin.pages.rewards.index')->name('users.rewards');
        Route::view('/users/deductions','admin.pages.deductions.index')->name('users.deductions');
        Route::view('/users/deductions/create','admin.pages.deductions.create')->name('users.deductions.create');
        Route::view('/users/shifts-types','admin.pages.shifts_types.index')->name('shifts_types');
        Route::view('/users/advance-payments','admin.pages.advance_payments.index')->name('users.advance_payments');

        Route::view('/users/salaries/current-year','admin.pages.salaries.current_year')->name('users.salaries.current_year');
        Route::view('/users/salaries/prev-years','admin.pages.salaries.prev_years')->name('users.salaries.prev_years');
        Route::view('/users/salaries/create/{user_id}','admin.pages.salaries.create')->name('users.salaries.create');
        Route::view('/users/salaries/update/{user_id}','admin.pages.salaries.update')->name('users.salaries.update');

        Route::view('/users/shifts/current-year','admin.pages.shifts.current_year')->name('users.shifts.current_year');
        Route::view('/users/shifts/prev-years','admin.pages.shifts.prev_years')->name('users.shifts.prev_years');
        Route::view('/users/shifts/create/{user_id}','admin.pages.shifts.create')->name('users.shifts.create');

        Route::view('/units','admin.pages.units.index')->name('units');
        Route::view('/categories','admin.pages.categories.index')->name('categories');
        Route::view('/products','admin.pages.products.index')->name('products');
        Route::view('/products/commissions','admin.pages.products.commissions')->name('products.commissions');
        // Route::view('/products/commissions/create','admin.pages.products.create_commission')->name('products.commissions');
        Route::view('/product/show/{id}','admin.pages.products.show')->name('product.show');
        Route::view('/product/print-code/{id}/{code}','admin.pages.products.print_code')->name('product.print_code');

        Route::view('/products/offers','admin.pages.offers.index')->name('products.offers');

        Route::view('/branches','admin.pages.branches.index')->name('branches');

        Route::view('/banks','admin.pages.banks.index')->name('banks');
        Route::view('/banks/transactions','admin.pages.banks_transactions.index')->name('bank.transactions');
        Route::view('/banks/transactions/create/exchange/{inv_num?}','admin.pages.banks_transactions.create_exchange_check')->name('bank.transactions.create_exchange_check');
        Route::view('/banks/transactions/create/collection/{inv_num?}','admin.pages.banks_transactions.create_collection_check')->name('bank.transactions.create_collection_check');


        Route::view('/banks-accounts','admin.pages.banks.accounts')->name('banks.accounts');
        // Route::view('/banks-accounts/create','admin.pages.banks.create_account')->name('banks.accounts.create');

        Route::view('/inventories','admin.pages.inventories.index')->name('inventories');

        Route::view('/financial/cost-centers','admin.pages.cost_centers.index')->name('cost.centers');
        Route::view('/financial/accounts-types','admin.pages.accounts_types.index')->name('financial_accounts_types');
        Route::view('/financial/accounts','admin.pages.accounts.index')->name('financial_accounts');
        Route::view('/financial/journal-entries','admin.pages.journal_entries.index')->name('journal_entries');
        Route::view('/financial/journal-entries/create','admin.pages.journal_entries.create')->name('journal_entries.create');
        Route::view('/financial/t-accounts','admin.pages.t_accounts.index')->name('t_accounts');
        Route::view('/financial/ledgers','admin.pages.ledgers.index')->name('ledgers');
        Route::view('/financial/ledgers/show/{account_id}','admin.pages.ledgers.show')->name('ledgers.show');
        //ميزان المراجعة
        Route::view('/financial/trail-balance-before-final-statements','admin.pages.trail_balance_before.index')->name('trail_balance_before');
        Route::view('/financial/uni-trail-balance-before-final-statements','admin.pages.uni_trail_balance_before.index')->name('uni_trail_balance_before');

        //التسويات الجردية
        Route::view('/financial/adjustments/treasuries', 'admin.pages.adjustments.treasuries')->name(name: 'treasuries_adjustment');// تسويات الخزن 
        Route::view('/financial/adjustments/treasuries/add', 'admin.pages.adjustments.add_treasury_adjustment')->name(name: 'add_treasury_adjustment');// إضافة تسوية الخزينة
        Route::view('/financial/adjustments/bank', 'admin.pages.adjustments.bank')->name(name: 'bank_adjustment');// تسوية البنك
        Route::view('/financial/adjustments/customers', 'admin.pages.adjustments.customers')->name(name: 'customers_adjustment');// تسوية العملاء
        Route::view('/financial/adjustments/inventories', 'admin.pages.adjustments.inventories')->name(name: 'inventories_adjustment');// تسوية العملاء

        Route::view('/financial/statement-of-financial-position','admin.pages.statement_of_financial_position.index')->name('statement_of_financial_position');
        Route::view('/financial/income-list','admin.pages.income_list.index')->name('income_list');
        Route::view('/financial/closing-entry','admin.pages.closing_entries.index')->name('closing_entry');
        Route::view('/financial/net-profit', 'admin.pages.net_profit.index')->name('net_profit');
        Route::view('/financial/trail-balance-after-final-statements','admin.pages.trail_balance_after.index')->name('trail_balance_after');
        Route::view('/financial/taxes','admin.pages.taxes.index')->name('taxes');
        Route::view('/financial/taxes/adjusting','admin.pages.taxes.adjust_taxes_with_zatca')->name('adjust_taxes');



        Route::view('/stores','admin.pages.stores.index')->name('stores');
        Route::view('/stores/transactions','admin.pages.stores.transactions')->name('stores.transactions');
        Route::view('/stores/transactions/add','admin.pages.stores.create_transaction')->name('stores.create_transaction');
        Route::view('/store/transaction/approve/{trans_num}','admin.pages.stores.approve_transaction')->name('stores.transactions.approve');
        Route::view('/store/transaction/edit/{trans_num}','admin.pages.stores.edit_transaction')->name('stores.transactions.edit');
        Route::view('/store/transaction/items/{trans_num}','admin.pages.stores.transaction_items')->name('stores.transactions.items');

        Route::view('/stores/inventory-counts/all','admin.pages.stores.inventory_counts')->name('stores.inventory_counts');
        Route::view('/stores/inventory-counts/create-all','admin.pages.stores.create_inventory_count')->name('stores.create_inventory_count');
        Route::view('/stores/inventory-counts/create-selected','admin.pages.stores.create_selected_inventory_count')->name('stores.create_selected_inventory_count');
        Route::view('/stores/inventory-settlements','admin.pages.stores.inventory_settlements')->name('stores.inventory_settlements');
        Route::view('/stores/inventory','admin.pages.stores.inventory')->name('stores.inventory');

        Route::view('/treasuries','admin.pages.treasuries.index')->name('treasuries');
        Route::view('/treasuries/shifts','admin.pages.treasury_shifts.index')->name('treasury_shifts');
        Route::view('/treasuries/transactions','admin.pages.treasury_transactions.index')->name('treasury.transactions');

        Route::view('/suppliers','admin.pages.suppliers.index')->name('suppliers');
        Route::view('/suppliers/invoices','admin.pages.suppliers.invoices')->name('suppliers.invoices');
        Route::view('/suppliers/invoices/add','admin.pages.suppliers.create_invoice')->name('suppliers.create_invoice');
        Route::view('/suppliers/invoices/items/add/{invoice_num}','admin.pages.suppliers.create_invoice_items')->name('suppliers.create_invoice_items');
        Route::view('/suppliers/invoices/show/{id}','admin.pages.suppliers.show_invoice')->name('suppliers.show_invoice');
        Route::view('/suppliers/invoices/edit/{inv_num}','admin.pages.suppliers.edit_invoice')->name('suppliers.edit_invoice');
        Route::view('/suppliers/invoices/returns','admin.pages.suppliers_returns.index')->name('suppliers.returns');

       
        Route::view('/customers','admin.pages.customers.index')->name('customers');
        Route::view('/customers/invoices','admin.pages.customers.invoices')->name('customers.invoices');
        Route::view('/customers/invoices/add','admin.pages.customers.create_invoice')->name('customers.create_invoice');

        Route::view('/customers/returns','admin.pages.customers_returns.index')->name('customers.returns');
        Route::view('/customers/returns/add/{inv_num?}','admin.pages.customers_returns.create_invoice_return')->name('customers.create_invoice_return');
        Route::view('/customers/returns/show/{return_num}','admin.pages.customers_returns.show_invoice_return')->name('customers_returns.show_return');
        Route::view('/customers/returns/print/{return_num}','admin.pages.customers_returns.print_return')->name('customers_returns.print_return');

        Route::view('/customers/invoices/debit_notes','admin.pages.customers_debit_notes.index')->name('customers.debit_notes');
        Route::view('/customers/invoices/debit_notes/add/{inv_num?}','admin.pages.customers_debit_notes.create')->name('customers.create_debit_note');
        Route::view('/customers/invoices/debit_notes/show/{debit_note_num}','admin.pages.customers_debit_notes.show_debit_note')->name('customers_debit_notes.show_debit_note');
        Route::view('/customers/invoices/debit_notes/print/{debit_note_num}','admin.pages.customers_debit_notes.print_debit_note')->name('customers_debit_notes.print_debit_note');

        Route::view('/customers/exchange/pos/{customer_id}','admin.pages.customers.exchange_pos')->name('customers.pos');
        Route::view('/customers/invoices/items/add/{invoice_num}','admin.pages.customers.create_invoice_items')->name('customers.create_invoice_items');
        Route::view('/customers/invoices/show/{id}','admin.pages.customers.show_invoice')->name('customers.show_invoice');

        // Route::view('/customers/invoices/edit/{inv_num}/{type}','admin.pages.customers.edit_invoice')->name('customers.edit_invoice');
        Route::view('/customers/invoices/visa-pay/{inv_num}','admin.pages.customers.visa_pay_invoice')->name('customers.visa_pay_invoice');
        Route::view('/customers/invoices/cash-payment/{inv_num}','admin.pages.customers.cash_pay_invoice')->name('customers.cash_pay_invoice');

        Route::view('/customers/invoices/print/{inv_num}','admin.pages.customers.print_invoice')->name('customers.print_invoice');



        Route::view('/customers/invoices/pay-invoice-installment/{inv_num}','admin.pages.customers.pay_invoice_installment')->name('customers.pay_invoice_installment');

        Route::view('/collections-receipts','admin.pages.collection_receipts.index')->name('collection_receipts');
        Route::view('/exchange-receipts','admin.pages.exchanges_receipts.index')->name('exchange_receipts');

        Route::view('/add/exchange-receipts/{inv_num?}','admin.pages.treasury_transactions.create')->name('create_exchange_reciept');
        Route::view('/add/collection-receipts/{inv_num?}','admin.pages.treasury_transactions.create')->name('create_collection_reciept');

        Route::view('/users','admin.pages.users.index')->name('users');


        Route::view('/account-statements','admin.pages.account_statements.index')->name('account_statements');
        Route::view('/account-statements/show/{account_id}','admin.pages.account_statements.show')->name('account_statements.show');


        Route::view('/reports/products-shortcomings','admin.pages.reports.shortcomings')->name('reports.shortcomings');
        Route::view('/reports/treasuries-transactions','admin.pages.reports.treasuries_transactions')->name('reports.treasuries_transactions');
        Route::view('/reports/banks-transactions','admin.pages.reports.banks_transactions')->name('reports.banks_transactions');
        Route::view('/reports/inventories-transactions','admin.pages.reports.inventories_transactions')->name('reports.inventories_transactions');
        Route::view('/reports/purchases','admin.pages.reports.purchases')->name('reports.purchases');
        Route::view('/reports/sales','admin.pages.reports.sales')->name('reports.sales');
        Route::view('/reports/account-statement','admin.pages.reports.account_statement')->name('reports.account_statement');








        //controllers

        Route::get('/roles',[RoleController::class,'index'])->name('roles');
        Route::post('/roles/store',[RoleController::class,'store'])->name('roles.store');
        Route::post('/roles/update/{id}',[RoleController::class,'update'])->name('roles.update');
        Route::post('/roles/delete/{id}',[RoleController::class,'delete'])->name('roles.delete');

        // Route::get('/invoices/print/{id}',[PrintInvoiceController::class,'print'])->name('invoices.print');

        // Route::get('/user-shifts/amount/{amount_state}',[AmountStateController::class,'getAmountState'])->name('user_shifts.state');



        // Route::view('/products/pdf','admin.pages.products.exportToPdf')->name('products.pdf');
        // Route::view('/invoices/{statusFilter?}','admin.pages.invoices.index')->name('invoices');
        // Route::view('/invoices/create','admin.pages.invoices.create')->name('invoices.create');
        // Route::view('/invoices/show/{id}','admin.pages.invoices.show')->name('invoices.show');
        // Route::view('/permissions','admin.pages.permissions.index')->name('permissions');
        // Route::view('/users','admin.pages.users.index')->name('users');




        //controllers//

        // Route::get('/roles',[RoleController::class,'index'])->name('roles');
        // Route::post('/roles/store',[RoleController::class,'store'])->name('roles.store');
        // Route::post('/roles/update/{id}',[RoleController::class,'update'])->name('roles.update');
        // Route::post('/roles/delete/{id}',[RoleController::class,'delete'])->name('roles.delete');
        // Route::get('/invoices/print/{id}',[PrintInvoiceController::class,'print'])->name('invoices.print');

        Route::get('/notifications',[NotificationController::class,'index'])->name('notifications');
        Route::get('/notifications/show/{id}',[NotificationController::class,'show'])->name('notifications.show');
        Route::get('/notification/unread/{id}',function(){
            Auth::user()->notifications::where('id',$id)->markAsRead();
        })->name('notification.unread');



        Route::get('/user/edit-profile',[ProfileController::class,'editProfile'])->name('user.edit_profile');
        Route::post('/user/update-profile',[ProfileController::class,'updateProfile'])->name('user.update_profile');

        Route::get('/user/change-password',[ProfileController::class,'editPassword'])->name('user.edit_password');
        Route::post('/user/update-password',[ProfileController::class,'updatepassword'])->name('user.update_password');

        // Route::get('/settings/edit',[SettingController::class,'edit'])->name('settings.edit');
        // Route::post('/settings/updtae',[SettingController::class,'update'])->name('settings.update');


        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/update', $handle);
        // });


        //zatca coomands
        Route::view('/zatca/settings/edit','admin.pages.settings.edit')->name('zatca_settings.edit');

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/update', $handle);
        });

});



require __DIR__.'/auth.php';
