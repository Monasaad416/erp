<?php

namespace App\Providers;

use App\Events\SalaryAdded;
use App\Events\NewInvoiceEvent;
use App\Events\NewTreasuryShift;
use App\Events\ItemReturnedEvent;

use App\Events\NewPartnerCapital;
use App\Events\NewAssetAddedEvent;
use App\Events\CheckInventoryCount;
use App\Events\NewSuppInvoiceEvent;
use App\Events\AddExchangeWithEntry;
use App\Events\NewCapitAlAddedEvent;
use App\Events\NewPartnerWithdrawal;
use App\Events\TaxesAdjustmentEvent;
use App\Listeners\AddToShortcomings;
use App\Events\DeleteCustomerInvoice;
use App\Events\NewTreasuryShiftEvent;
use App\Events\SuppItemReturnedEvent;
use Illuminate\Support\Facades\Event;
use App\Events\AddCollectionWithEntry;
use App\Listeners\CreateSuppInvReturn;
use Illuminate\Auth\Events\Registered;
use App\Events\NewBankTransactionEvent;
use App\Events\NewCustomerInvoiceEvent;
use App\Listeners\CreateSuppItemReturn;
use App\Events\AddBankExchangeWithEntry;
use App\Events\SuppInvoiceReturnedEvent;
use App\Listeners\SalaryAddedFinancials;
use App\Events\CustomerNewDebitNoteEvent;
use App\Events\InventoryTransactionEvent;
use App\Events\AddBankCollectionWithEntry;
use App\Events\CustomerInvoiceInstallment;
use App\Listeners\NewAssetAddedFinancilas;
use App\Events\NewTreasuryTransactionEvent;
use App\Events\AssetsDepreciationAddedEvent;
use App\Events\CustomerInvItemReturnedEvent;
use App\Events\CustomerInvoiceReturnedEvent;
use App\Listeners\FinancialsAfterNewInvoice;
use App\Listeners\NewCapitAlAddedFinancials;
use App\Listeners\TaxesAdjustmentFinancials;
use App\Events\InvoicePartiallyReturnedEvent;
use App\Events\TaxesAdjustmentWithZatcaEvent;
use App\Listeners\NewTreasuryShiftFinancials;
use App\Events\CustomerPartiallyReturnedEvent;
use App\Events\FinancialYearClosingEntryEvent;
use App\Listeners\FinancialsAfterItemReturned;
use App\Listeners\FinancialsAfterNewBankTrans;
use App\Listeners\NewPartnerCapitalFinancials;
use App\Events\RejectInventoryTransactionEvent;
use App\Listeners\AssetsDepreciationFinancials;
use App\Listeners\ClosingEntryForFinancialYear;
use App\Listeners\AddExchangeWithEntryFinancial;
use App\Listeners\CreateSuppItemPartiallyReturn;
use App\Listeners\FinancialsAfterNewSuppInvoice;
use App\Events\SuppInvoicePartiallyReturnedEvent;
use App\Listeners\DeleteCustomerInvoiceFinancial;
use App\Listeners\FinancialsAfterInvPartReturned;
use App\Listeners\InventoryTransactionFinancials;
use App\Listeners\NewPartnerWithdrawalFinancials;
use App\Events\SupplierInvoiceItemPartReturnEvent;
use App\Listeners\AddCollectionWithEntryFinancial;
use App\Listeners\FinancialsAfterNewTreasuryTrans;
use App\Listeners\FinancialsAfterSuppItemReturned;
use App\Listeners\FinancialsAfterCustomerDebitNote;
use App\Listeners\AddBankExchangeWithEntryFinancial;
use App\Listeners\FinancialsAfterNewCustomerInvoice;
use App\Events\CustomerInvoicePartiallyReturnedEvent;
use App\Events\NewTreasuryCollectionTransactionEvent;
use App\Listeners\FinancialsAfterSuppInvoiceReturned;
use App\Listeners\FinancialsAfterSuppInvPartReturned;
use App\Listeners\TaxesAdjustmentWithZatcaFinancials;
use App\Listeners\AddBankCollectionWithEntryFinancial;
use App\Listeners\FinancialsAfterCustomerItemReturned;
use App\Listeners\FinancialsAfterCustomerPartReturned;
use App\Listeners\CustomerInvoiceInstallmentFinancials;
use App\Listeners\RejectInventoryTransactionFinancials;
use App\Listeners\FinancialsAfterCustomerInvoiceReturned;
use App\Listeners\FinancialsAfterCustomerInvPartReturned;
use App\Listeners\FinancialsSupplierInvoiceItemPartReturn;
use App\Listeners\FinancialsAfterNewTreasuryCollectionTrans;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        NewSuppInvoiceEvent::class => [
            FinancialsAfterNewSuppInvoice::class,
        ],
        NewCustomerInvoiceEvent::class => [
            FinancialsAfterNewCustomerInvoice::class,
        ],

        SuppInvoiceReturnedEvent::class => [
            FinancialsAfterSuppInvoiceReturned::class,

        ],

        SuppInvoicePartiallyReturnedEvent::class => [
            FinancialsAfterSuppInvPartReturned::class,
        ],


        CustomerInvoicePartiallyReturnedEvent::class => [
            FinancialsAfterCustomerInvPartReturned::class,//مرتجع مرتبط بفاتورة
        ],

        CustomerNewDebitNoteEvent::class => [
            FinancialsAfterCustomerDebitNote::class,
        ],

        CustomerPartiallyReturnedEvent::class => [
            FinancialsAfterCustomerPartReturned::class,//مرتجع غير مرتبط بفاتورة
        ],


        SuppItemReturnedEvent::class => [
            FinancialsAfterSuppItemReturned::class,
        ],


        NewTreasuryTransactionEvent::class => [
            FinancialsAfterNewTreasuryTrans::class,
        ],
        NewTreasuryCollectionTransactionEvent::class => [
            FinancialsAfterNewTreasuryCollectionTrans::class,
        ],

        NewBankTransactionEvent::class => [
            FinancialsAfterNewBankTrans::class,
        ],
        NewAssetAddedEvent::class => [
            NewAssetAddedFinancilas::class,
        ],
        CheckInventoryCount::class => [
            AddToShortcomings::class,
        ],

        InventoryTransactionEvent::class => [
            InventoryTransactionFinancials::class,
        ],
        RejectInventoryTransactionEvent::class => [
            RejectInventoryTransactionFinancials::class,
        ],

        NewTreasuryShiftEvent::class => [
            NewTreasuryShiftFinancials::class,
        ],

        AssetsDepreciationAddedEvent::class => [
            AssetsDepreciationFinancials::class,
        ],

        NewCapitAlAddedEvent::class => [
            NewCapitAlAddedFinancials::class,
        ],
        SalaryAdded::class => [
            SalaryAddedFinancials::class,
        ],

        SupplierInvoiceItemPartReturnEvent::class => [
            FinancialsSupplierInvoiceItemPartReturn::class,
        ],
        CustomerInvoiceInstallment::class =>[
            CustomerInvoiceInstallmentFinancials::class,
        ],
        AddCollectionWithEntry::class =>[
            AddCollectionWithEntryFinancial::class,
        ],
        AddExchangeWithEntry::class =>[
            AddExchangeWithEntryFinancial::class,
        ],
        AddBankCollectionWithEntry::class => [
            AddBankCollectionWithEntryFinancial::class,
        ],
        AddBankExchangeWithEntry::class => [
            AddBankExchangeWithEntryFinancial::class,
        ],
        DeleteCustomerInvoice::class =>[
            DeleteCustomerInvoiceFinancial::class,
        ],
        FinancialYearClosingEntryEvent::class =>[
            ClosingEntryForFinancialYear::class,
        ],

        TaxesAdjustmentEvent::class =>[
            TaxesAdjustmentFinancials::class,
        ],

        NewPartnerWithdrawal::class =>[
            NewPartnerWithdrawalFinancials::class,
        ],


    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
