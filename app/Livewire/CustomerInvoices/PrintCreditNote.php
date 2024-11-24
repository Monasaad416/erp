<?php

namespace App\Livewire\CustomerInvoices;

use Livewire\Component;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\TaxNumber;
use Salla\ZATCA\Tags\InvoiceDate;
use App\Models\CustomerInvoiceItem;
use App\Models\Setting;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;

class PrintCreditNote extends Component
{

    public $invoice,$invoiceItems,$seller_name,$vat_num,$time_stamps,$inv_total,$vat_total, $displayQRCodeBase64,$settings;

    //302182336900003

    public function mount($invoice)
    {
        $this->invoice = $invoice;
        $this->seller_name = 'صيدليةالرعاية';
        $this->vat_num = '354567890987653';
        $this->time_stamps = $invoice->customer_inv_date_time;
        $this->inv_total = $invoice->total_after_discount;
        $this->vat_total = $invoice->tax_value;
        $this->invoiceItems = CustomerInvoiceItem::where('customer_invoice_id', $this->invoice->id)->get();
        $this->settings = Setting::findOrFail(1);
        //dd($invoice);
    }

    public function getQrCode(){
        $this->displayQRCodeBase64 = GenerateQrCode::fromArray([
            new Seller($this->seller_name), // seller name
            new TaxNumber($this->vat_num), // seller tax number
            new InvoiceDate($this->time_stamps), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($this->inv_total), // invoice total amount
            new InvoiceTaxAmount($this->vat_total), // invoice tax amount

        ])->render();
    }



    // public function getSellerNameTLVStructure()
    // {
    //     $tag = 01;
    //     $length = mb_strlen($this->seller_name, 'UTF-8');
    //     $value = $this->seller_name;
    // }
    // public function getVatNumTLVStructure()
    // {
    //     $tag = 02;
    //     $length = mb_strlen($this->vat_num, 'UTF-8');
    //     $value = $this->vat_num;
    // }
    // public function getTimeStampsTLVStructure()
    // {
    //     $tag = 03;
    //     $length = mb_strlen($this->time_stamps, 'UTF-8');
    //     $value = $this->time_stamps;
    // }

    // public function getInvTotalTLVStructure()
    // {
    //     $tag = 04;
    //     $length = mb_strlen($this->inv_total, 'UTF-8');
    //     $value = $this->inv_total;
    // }
    // public function getVatTLVStructure()
    // {
    //     $tag = 05;
    //     $length = mb_strlen($this->vat_total, 'UTF-8');
    //     $value = $this->vat_total;
    // }

    // public function encodeToBase64()
    // {
    //     $dataToEncode = [
    //         [1, $this->seller_name],
    //         [2, (int)$this->vat_num],
    //         [3, $this->time_stamps],
    //         [4, $this->inv_total],
    //         [5, $this->vat_total]
    //     ];

    //     $tlv = '';

    //     foreach ($dataToEncode as $data) {
    //         $tag = str_pad($data[0], 2, '0', STR_PAD_LEFT);
    //         $value = $data[1];
    //         $length = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
    //         $tlv .= hex2bin($tag) . hex2bin($length) . $value;
    //     }
    //     dd($tlv);

    //     return base64_encode($tlv);

    // }

    // public function convertStringToHexa()
    // {
    //     $string = "Hello, World!";
    //     $hex = bin2hex($string);
    //     dd($hex);
    // }
    public function render()
    {
        $this->getQrCode();

        return view('livewire.customer-invoices.print-invoice');
    }
}
